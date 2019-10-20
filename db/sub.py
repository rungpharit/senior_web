import paho.mqtt.client as mqtt
import mysql.connector as mariadb
import json
from db import topic_check

MQTT_SERVER = "test.mosquitto.org"
MQTT_PORT = 1883
KEEP_ALIVE=60
MQTT_TOPIC = "Home/receive/#"
#Home/receive/topic_signup
#Home/receive/topic_sign_in
#Home/receive/topic_email
#Home/receive/topic_get_data

def on_connect(client,userdata,flag,rc):
    print("Connected with result code"+str(rc))
    client.subscribe(MQTT_TOPIC)

def on_message(client,userdata,msg):
    print("MQTT Data Received+ ...")
    print("Data : "+str(msg.payload))
    print("MQTT Topic : "+msg.topic)

    topic_check(msg.topic,msg.payload)

mqttc=mqtt.Client()
mqttc.on_message = on_message
mqttc.on_connect = on_connect

mqttc.connect(MQTT_SERVER,1883,60)
mqttc.loop_forever()