import mysql.connector as mariadb
import json
import os
signup = "signup_user"
mariadb_connection = mariadb.connect(user='root', password='', database='test2')
cursor = mariadb_connection.cursor()

class Database():
    def db_open ():
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()

    def db_close ():       
        mariadb_connection.close()

    def signup_check_user(self,username): #Check all user before create table
        
        table = "signup_user"
        cursor.execute("SELECT username FROM {} WHERE username = '{}'".format(table,username))
        result = cursor.fetchall()
        if cursor.rowcount > 0 :
            #Can signup and send bact to app          
            return "TAKEN"
        else :
            #Can't signup and send back to app           
            return "APPROVE"
       
    def signup_table(self,username) : #Create all table here
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()

        table_t = username + "_" + "threshold"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,threshold INT,PRIMARY KEY(count))".format(table_t))
        
        table_d = username + "_" + "data"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,date VARCHAR(255),timee VARCHAR(255),intensity VARCHAR(255),cumulative VARCHAR(255),uvindex VARCHAR(255),zenith VARCHAR(255),azimuth VARCHAR(255),latitude VARCHAR(255),longtitude VARCHAR(255),PRIMARY KEY(count))".format(table_d))
        
        table_f = username + '_' + "feeling"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,date VARCHAR(255),timee VARCHAR(255),informtext TEXT,symp TEXT,level INT,PRIMARY KEY(count))".format(table_f))

        table_r = username + '_' + "rash"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,date VARCHAR(255),timee VARCHAR(255),PRIMARY KEY(count))".format(table_r))

        table_w = username + '_' + "warn"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,sympans VARCHAR(255),PRIMARY KEY(count))".format(table_w))

        table_s = username + '_' + "specific_symptom"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,date VARCHAR(255),timee VARCHAR(255),symptom VARCHAR(255),PRIMARY KEY(count))".format(table_s))
        
        table_a = username + '_' + "appuse"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,appuse INT,PRIMARY KEY(count))".format(table_a))

        table_i = username + '_' + "images"
        cursor.execute("CREATE TABLE {} (count INT NOT NULL AUTO_INCREMENT,date VARCHAR(255),imagename VARCHAR(255),PRIMARY KEY(count))".format(table_i))
        path = "D:\XAMPP\htdocs\project_done\img\patient\{}".format(username) #Create folder
        os.makedirs(path)
        
        
    def signup_insert(self,signup_data):
        #Before inserting value you have to know what is the last id 
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor      = mariadb_connection.cursor()
        table       = "signup_user"
        cursor.execute("SELECT id FROM {} ".format(table))   #Find id     
        result      = cursor.fetchall()  
        #Inital value     
        rama        = '01'
        ramaa       = '0'

        if len(result) == 0 : #No id in db
            
            init    = '0000'
            i       = rama + init
            
        else:
           
            for row in result :              
                init = int(row[0])
  
            init    = init + 1            
            init    = str(init)
            i       = ramaa + init
            

        #Parse data

        name  = surname  =  birthday= sex   = job=address  = city  = country  = nationality = email   = disease   =username   =password    = ""
        
        data        = json.loads(signup_data)
        name        = data['name']
        surname     = data['surname']
        day         = data['birthday']['day']
        month       = data['birthday']['month']
        year        = data['birthday']['year']
        day         = str(day)
        month       = str(month)
        year        = str(year)
        birthday    = year + "/" + month + "/" +  day
        sex         = data['sex']
        job         = data['job']
        address     = data['address']
        city        = data['city']
        country     = data['country']
        nationality = data['nationality']
        email       = data['E-mail']
        disease     = data['disease']
        username    = data['username']
        password    = data['password']
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')  
        cursor = mariadb_connection.cursor()    
        cursor.execute("INSERT INTO {} (id,name,surname,birthday,sex,job,address,city,country,nationality,email,disease,username,password) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format(table),[i,name,surname,birthday,sex,job,address,city,country,nationality,email,disease,username,password])    
        mariadb_connection.commit()
        mariadb_connection.close()
        
    def send_back(self,path,send_back):
        print("PATH : "+str(path))
        print("M : " + str(send_back) )
        publish_app(path,send_back)

    #def signin_send_back(self,path,send_back):


    def signin_check (self,data):
        data            = data.decode('utf8').replace("'", '"')
        signin          = json.loads(data)
        randomNumber    = signin['randomNumber']
        username        = signin['username']
        password        = signin['password']
        
        cursor.execute("SELECT username FROM signup_user WHERE username = '{}'".format(username))
        result_user     = cursor.fetchall()
        cursor.execute("SELECT password FROM signup_user WHERE password = '{}' and username = '{}'".format(password,username))
        result_pass     = cursor.fetchall()
        
        if result_pass == [] or result_user == []:
            signin_back                     = '{"randomNumber":"","reply":""}'
            signin_back                     = json.loads(signin_back)         
            signin                          = "INCORRECT"   
            signin_back["randomNumber"]     = randomNumber
            signin_back["reply"]            = signin
            return signin_back

        else :    
            username_check              = result_user[0][0]
            password_check              = result_pass[0][0]
            signin                      = "CORRECT"
            signin_back                 = '{"randomNumber":"","reply":""}'
            signin_back                 = json.loads(signin_back)
            signin_back['randomNumber'] = randomNumber
            signin_back['reply']        = signin            
            signin_back                 = str(signin_back)
            return signin_back

    def threshold_insert(self,data) :
        thres       = data
        username    = thres['username']
        threshold   = thres['threshold']
        word        = "threshold"
        table       = username + "_" + word
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO {} (threshold) VALUES (%s) ".format(table),[threshold])
        mariadb_connection.commit()
        mariadb_connection.close()

    def threshold_send(self,data) :
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor          = mariadb_connection.cursor()
        thres           = data
        randomNumber    = thres['randomNumber']
        username        = thres['username']
        word            = "threshold"
        table           = username + "_" + word
        
        cursor.execute("SELECT threshold FROM {}  ".format(table))
        result_thres    = cursor.fetchall()
        for row in result_thres :              
                th = int(row[0])

        threshold                   = '{"randomNumber":"","status":"PHONE_ASK","username":"","threshold":""}'
        threshold                   = json.loads(threshold)
        threshold['randomNumber']   = randomNumber
        threshold['username']       = username
        threshold['threshold']      = th
        threshold                   = str(threshold)
        return threshold

    def data_insert(self,data) :
        username        = data['username']
        day             = data['date']['day']
        month           = data['date']['month']
        year            = data['date']['year']
        day             = str(day)
        month           = str(month)
        year            = str(year)
        date            = year + '/' + month + '/' + day
        hour            = data['time']['hour']
        minute          = data['time']['minute']
        second          = data['time']['second']
        hour            = str(hour )
        minute          = str(minute)
        second          = str(second)
        timee           = hour + ':' + minute + ':' + second
        insensity       = data['uvIntensity']
        cumulative      = data['cumulativeUV']
        uvindex         = data['uvIndex']
        zenith          = data['solarAngle']['zenith']
        azimuth         = data['solarAngle']['azimuth']
        latitude        = data['GPS']['latitude']
        longtitude      = data['GPS']['longitude']
    
        table           = username + '_' + 'data'
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor          = mariadb_connection.cursor()

        cursor.execute("INSERT INTO {} (date,timee,intensity,cumulative,uvindex,zenith,azimuth,latitude,longtitude) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)".format(table),[date,timee,insensity,cumulative,uvindex,zenith,azimuth,latitude,longtitude])
        mariadb_connection.commit()
        mariadb_connection.close()

    def feeling_insert(self,data):
        username    = data['username'] 
        day         = data['date']['day']
        month       = data['date']['month']
        year        = data['date']['year']
        day         = str(day)
        month       = str(month)
        year        = str(year)
        date        = year + '/' + month + '/' + day
        hour        = data['time']['hour']
        minute      = data['time']['minute']
        second      = data['time']['second']
        hour        = str(hour )
        minute      = str(minute)
        second      = str(second)
        timee       = hour + ':' + minute + ':' + second
        informtext  = data['informedText']
        level       = data['level']
        symp        = data['symptom']

        table = username + '_' + 'feeling'
        timee = hour + ':' + minute + ':' + second
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO {} (date,timee,informtext,symp,level) VALUES (%s,%s,%s,%s,%s)".format(table),[date,timee,informtext,symp,level])
        mariadb_connection.commit()
        mariadb_connection.close()

    def rash_insert(data) :
        
        username    = data['username'] 
        day         = data['date']['day']
        month       = data['date']['month']
        year        = data['date']['year']
        day         = str(day)
        month       = str(month)
        year        = str(year)
        date        = year + '/' + month + '/' + day
        hour        = data['time']['hour']
        minute      = data['time']['minute']
        second      = data['time']['second']
        hour        = str(hour )
        minute      = str(minute)
        second      = str(second)
        timee       = hour + ':' + minute + ':' + second
        table       = username + '_' + 'rash'
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO {} (date,timee) VALUES (%s,%s)".format(table),[date,timee])
        mariadb_connection.commit()
        mariadb_connection.close()

    def specific_symptom(self,data) :
        username    = data['username'] 
        day         = data['date']['day']
        month       = data['date']['month']
        year        = data['date']['year']
        day         = str(day)
        month       = str(month)
        year        = str(year)
        date        = year + '/' + month + '/' + day
        hour        = data['time']['hour']
        minute      = data['time']['minute']
        second      = data['time']['second']
        hour        = str(hour )
        minute      = str(minute)
        second      = str(second)
        symptom     = data['symptom']
        timee       = hour + ':' + minute + ':' + second
        table       = username + '_' + 'specific_symptom'
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO {} (date,timee,symptom) VALUES (%s,%s,%s)".format(table),[date,timee,symptom])
        mariadb_connection.commit()
        mariadb_connection.close()

    def ask_history(self,data) :
        randomNumber    = data['randomNumber']
        username        = data['username'] 
        day             = data['date']['day']
        month           = data['date']['month']
        year            = data['date']['year']
        day             = str(day)
        month           = str(month)
        year            = str(year)
        date            = year + '/' + month + '/' + day
        table           = username + '_' + 'data'
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("SELECT intensity FROM {} WHERE date = '{}'".format(table,date))
        result_intensity = cursor.fetchall()
        cursor.execute("SELECT cumulative FROM {} WHERE date = '{}'  ".format(table,date))
        result_cumulative = cursor.fetchall()
        
        intent = []
        cumu = []
        
        if result_cumulative == [] or result_intensity == [] :
            his                     = "NO_DATA_RECORD"
            history                 = '{"randomNumber":"","reply":"" ,"username":""}'
            history                 = json.loads(history)
            history['username']     = username
            history['randomNumber'] = randomNumber
            history['reply']        = his
            return history
        
        else :
            his = "HAVE_DATA_RECORD"
            history = '{"randomNumber":"","reply":"","username":"","uvIntensity":"","cumulativeUV":""}'
            for x in range(len(result_intensity)) :
                    intent.append(result_intensity[x][0])

            for x in range(len(result_cumulative)) :
                    cumu.append(result_cumulative[x][0])
                    
            history                 = json.loads(history)
            history['username']     = username
            history['randomNumber'] = randomNumber        
            history['reply']        = his
            history['uvIntensity']  = intent
            history['cumulativeUV'] = cumu
            return history
               
        mariadb_connection.commit()
        mariadb_connection.close()

    def ask_profile(self,data):
        randomNumber    = data['randomNumber']
        username        = data['username']
        table           = "signup_user"

        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("SELECT * FROM {} WHERE username = '{}'".format(table,username))
        result = cursor.fetchall()

        id_user     = result[0][1]
        name        = result[0][2]
        surname     = result[0][3]
        birthday    = result[0][4]
        birthday    = str(birthday)
        sex         = result[0][5]
        job         = result[0][6]
        address     = result[0][7]
        city        = result[0][8]
        country     = result[0][9]
        nationality = result[0][10]
        email       = result[0][11]
        disease     = result[0][12]
        password    = result[0][13]
        ask = '{"randomNumber":"","id":"","name":"","surname":"","birthday":"","sex":"","job":"","address ":"","city":"","country":"","nationality":"","E-mail":"","disease":"","username":"","password":"" }'
        data = json.loads(ask)
        
        data['randomNumber'] = randomNumber
        data['id']           = id_user
        data['name']         = name
        data['surname']      = surname     
        data['birthday']     = birthday  
        data['sex']          = sex         
        data['job']          = job          
        data['address']      = address      
        data['city']         = city        
        data['country']      = country     
        data['nationality']  = nationality  
        data['E-mail']       = email      
        data['disease']      = disease      
        data['username']     = username     
        data['password']     = password 

        return data
    
    def warn_insert(self,data):
        username    = data['username'] 
        symptom     = data['sympAns']
        table       = username + '_' + "warn"
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO {} (sympans) VALUES (%s) ".format(table),[symptom])
        mariadb_connection.commit()
        mariadb_connection.close()

    def appuse_insert(self,data):
        username        = data['username'] 
        appuse_val      = data['appuse']
        table           = username + '_' + "appuse"
        
        mariadb_connection = mariadb.connect(user='root', password='', database='test2')
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO {} (appuse) VALUES (%s) ".format(table),[appuse_val])
        mariadb_connection.commit()
        mariadb_connection.close()

def signup(data) :
    path            = "Home/send/topic_signup_check"
    data            = data.decode('utf8').replace("'", '"') #Convert byte to string
    send            = json.loads(data)
    username        = ""
    username        = send['username']
    randomNumber    = send['randomNumber']
    db              = Database()
    db.db_open
    check_user      = db.signup_check_user(username) #Check user


    if check_user == "APPROVE" : 
        prove = "APPROVE"
        db.signup_insert(data) 
        db.signup_table(username)
        mariadb_connection = mariadb.connect(user='root', password='', database='test2') 
        cursor = mariadb_connection.cursor()
        cursor.execute("SELECT id  FROM signup_user WHERE username = '{}' ".format(username))
        result_signin  = cursor.fetchall()

        for row in result_signin :              
                id_signin = str(row[0])
                
        #send   back
        send_back                   = '{"randomNumber":"","reply":"","id":""}'
        send_back                   = json.loads(send_back)
        send_back['randomNumber']   = randomNumber
        send_back['reply']          = prove
        send_back['id']             = id_signin
        db.send_back(path,send_back)   
        db.db_close()

    elif check_user == "TAKEN" :
        prove = "TAKEN"  
        send_back = '{"randomNumber":"","reply":""}'
        send_back = json.loads(send_back)
        send_back['randomNumber'] = randomNumber
        send_back['reply'] = prove
        #send   back
        db.send_back(path,send_back)
        db.db_close()

def signin(data) :
    path    = "Home/send/topic_signin_check"
    db      = Database()
    signin  = db.signin_check(data)
    db.send_back(path,signin)

def threshold(data) :
    path    = "Home/send/topic_threshold_send"
    data    = data.decode('utf8').replace("'", '"')
    data    = json.loads(data)
    status  = data['status']
    db      = Database()
    
    if status == "FALSE" :
        db.threshold_insert(data)
    elif status == "PHONE_ASK" :
        val = db.threshold_send(data)
        db.send_back(path,val)

def data_receive(data):
    data    = data.decode('utf8').replace("'", '"')
    data    = json.loads(data)
    db      = Database()
    db.data_insert(data)
    
def feeling(data) :
    data    = data.decode('utf8').replace("'", '"')
    data    = json.loads(data)
    db      = Database()
    db.feeling_insert(data)

def rash(data) :
    data    = data.decode('utf8').replace("'", '"')
    data    = json.loads(data)
    db      = Database()
    db.rash_insert(data)

def symptom(data) :
    data    = data.decode('utf8').replace("'", '"')
    data    = json.loads(data)
    db      = Database()
    db.specific_symptom(data)

def history(data) :
    path    = "Home/send/topic_history"
    data    = data.decode('utf8').replace("'", '"')
    data    = json.loads(data)
    db      = Database()
    history_send = db.ask_history(data)
    db.send_back(path,history_send)

def warn(data) :
    data = data.decode('utf8').replace("'", '"')
    data = json.loads(data)
    db  = Database()
    db.warn_insert(data)

def appuse(data) :
    data = data.decode('utf8').replace("'", '"')
    data = json.loads(data)
    db = Database()
    db.appuse_insert(data)

def profile(data):
    path = "Home/send/topic_profile"
    data = data.decode('utf8').replace("'", '"')
    data = json.loads(data)
    
    db = Database()
    send_ask = db.ask_profile(data)
    db.send_back(path,send_ask)
def topic_check(topic,data) :
    if topic == "Home/receive/topic_signup" :
        print("... SIGN UP ...")
        signup(data)

    if topic == "Home/receive/topic_signin" :
        print("... SIGN IN ...")
        signin(data)

    if topic == "Home/receive/topic_ask_profile" :
        print(".. profile ..")
        profile(data)

    if topic == "Home/receive/topic_threshold" :
        print(".. THRESHOLD ..")
        threshold(data)

    if topic == "Home/receive/topic_data" :
        print(".. DATA ..")
        data_receive(data)

    if topic == "Home/receive/topic_feeling" :
        print(".. FEELING ..")
        feeling(data)

    if topic == "Home/receive/topic_rash" :
        print(".. RASH ..")
        rash(data)
    
    if topic == "Home/receive/topic_specific_symptom" :
        print(".. SYMPTOM ..")
        symptom(data)

    if topic == "Home/receive/topic_ask_history" :
        print(".. HISTORY ..")
        history(data)

    if topic == "Home/receive/topic_symptom_after_warn" :
        print(".. warn ..")
        warn(data)

    if topic == "Home/receive/topic_appuse" :
        print(".. APPUSE ..")
        appuse(data)
