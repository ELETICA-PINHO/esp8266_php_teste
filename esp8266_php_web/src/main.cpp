#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>



//Add WIFI data
const char* ssid = "IOT";              //Add your WIFI network name 
const char* password =  "iot12345";           //Add WIFI password
String  SERVER_IP = "http://192.140.10.139:1212/esp32/teste5.php";




unsigned int qtd_eventos = 0;
void chama5();


String LED_id = "1";                  //Just in case you control more than 1 LED
bool toggle_pressed = false;          //Each time we press the push button    
String data_to_send = "";             //Text data to send to the server
unsigned int Actual_Millis, Previous_Millis;
int refresh_time = 200;               //Refresh rate of connection to website (recommended more than 1s)

int cont = 0;

//Inputs/outputs
int button1 = 2;     //4;                     //Connect push button on this pin
int LED = 0;   //13;                          //Connect LED on this pin (add 150ohm resistor)


void ICACHE_RAM_ATTR pinTroca(){
 delayMicroseconds(100);
  toggle_pressed = true; 

}



void setup() {
  Serial.begin(115200);
  pinMode(LED, OUTPUT);
  pinMode(button1, INPUT);

  attachInterrupt(digitalPinToInterrupt(button1), pinTroca, FALLING);

   WiFi.begin(ssid, password);  
  Serial.println("");           //Start wifi connection
  Serial.print("CONECTANDO...");
  while (WiFi.status() != WL_CONNECTED) { //Check for the connection
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("CONECTADO, MEU IP: ");
  Serial.print(WiFi.localIP());
  Actual_Millis = millis();               //Save time for refresh loop
  Previous_Millis = Actual_Millis; 
  

}

void loop() {

  if ((WiFi.status() == WL_CONNECTED)) {

    WiFiClient client;
    HTTPClient http;

    //Serial.print("[HTTP] begin...\n");
    // configure traged server and url

    if(toggle_pressed){                               //If button was pressed we send text: "toggle_LED"
        data_to_send = "toggle_LED=" + LED_id;  
        toggle_pressed = false;                         //Also equal this variable back to false 
      }
      else{
        data_to_send = "check_LED_status=" + LED_id;    //If button wasn't pressed we send text: "check_LED_status"
      }






    
    http.begin(client, SERVER_IP ); //HTTP
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
     int response_code = http.POST(data_to_send);

        if(response_code > 0){
     //   Serial.println("HTTP code " + String(response_code));                     //Print return code
  
        if(response_code == 200){                                                 //If code is 200, we received a good response and we can read the echo data
          String response_body = http.getString();                                //Save the data comming from the website
          Serial.print("Server reply: ");                                         //Print data to the monitor for debug
          Serial.println(response_body);

          //If the received data is LED_is_off, we set LOW the LED pin
          if(response_body == "LED_is_on"){
             digitalWrite(LED, LOW);
          }
          //If the received data is LED_is_on, we set HIGH the LED pin
          else if(response_body == "LED_is_off"){
           
            digitalWrite(LED, HIGH);
          }  
        }//End of response_code = 200
      }//END of response_code > 0
  } // wifi verifica
          
}// loop



 