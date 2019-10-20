import paho.mqtt.client as mqtt
import json


MQTT_SERVER = "test.mosquitto.org"

def publish_app (path,send_value):
    MQTT_MSG = str(send_value)
    MQTT_PATH = path
    print(MQTT_PATH)
    print("MQTT_MSG :"+MQTT_MSG)
    
    pub(MQTT_PATH,MQTT_MSG)

# Define on_publish event function


def on_publish(client, userdata, mid):
	    print ("Message Published...")

def pub(MQTT_PATH,MQTT_MSG) :
        # Initiate MQTT Client
        mqttc = mqtt.Client()

        # Register publish callback function
        mqttc.on_publish = on_publish

        # Connect with MQTT Broker
        mqttc.connect(MQTT_SERVER, 1883, 60)		

        #  Publish message to MQTT Broker	
        mqttc.publish(MQTT_PATH,MQTT_MSG)
        print(MQTT_MSG)
        
        # Disconnect from MQTT_Broker
        mqttc.disconnect()
       
