#!/usr/bin/env python
#-*- coding: utf8 -*-
#
#    Copyright 2014,2018 Mario Gomez <mario.gomez@teubi.co>
#
#    This file is part of MFRC522-Python
#    MFRC522-Python is a simple Python implementation for
#    the MFRC522 NFC Card Reader for the Raspberry Pi.
#
#    MFRC522-Python is free software: you can redistribute it and/or modify
#    it under the terms of the GNU Lesser General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    MFRC522-Python is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU Lesser General Public License for more details.
#
#    You should have received a copy of the GNU Lesser General Public License
#    along with MFRC522-Python.  If not, see <http://www.gnu.org/licenses/>.
#

import RPi.GPIO as GPIO
import MFRC522
import signal
import sys 
import time 
import mysql.connector
import os
import Buzzer
import authConfig 

os.system("clear")

class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'

continue_reading = True

# Capture SIGINT for cleanup when the script is aborted
def end_read(signal,frame):
    global continue_reading
    print "";
    continue_reading = False
    GPIO.cleanup()

# Hook the SIGINT
signal.signal(signal.SIGINT, end_read)

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

# Create an object of the class Buzzer
buzzer = Buzzer.Buzzer(15)

# Welcome message
print bcolors.WARNING + "Press Ctrl-C to stop...\n" + bcolors.ENDC

# This loop keeps checking for chips. If one is near it will get the UID and authenticate
while continue_reading:
    
    # Scan for cards    
    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    time.sleep(0.1)

    # If a card isn't found
    if status != MIFAREReader.MI_OK:
        continue    

    # Get the UID of the card
    (status,uid) = MIFAREReader.MFRC522_Anticoll()

    # If we have the UID, continue
    if status == MIFAREReader.MI_OK: 

        # Format UID
        uid_formatted = ""
        for i in range(len(uid)):
            if i == len(uid)-1:
                uid_formatted += str(uid[i])
            else:
                uid_formatted += str(uid[i]) + ':'

        try:
            db = mysql.connector.connect(
                host=authConfig.hostname,
                user=authConfig.username,
                passwd=authConfig.password,
                database=authConfig.db
            )
        except mysql.connector.errors.ProgrammingError as e:
            print(e)
            sys.exit(1)

        try:
            cursor = db.cursor()
            cursor.execute("SELECT * FROM persons WHERE card_id = '" + uid_formatted + "';");
            result = cursor.fetchall()
            os.system("clear")
            if result:
                for x in result:
                    print bcolors.OKGREEN + "ACCESS GRANTED" + bcolors.ENDC
                    print "Person: %s %s" % (x[1], x[2]) 
                    print "UID: %s" % (uid_formatted)
                    print "Database ID: %s\n" % (x[0])
                buzzer.play(246.9, 5, 0.1, 0.1) 
            else:
                print bcolors.FAIL + "ACCESS DENIED" + bcolors.ENDC
                print "Person: unknown" 
                print "UID: %s" % (uid_formatted)
                print "Database ID: unknown\n"
                buzzer.play(900, 5, 0.1, 0.1) 
        except mysql.connector.errors.ProgrammingError as e:
            print(e)
            sys.exit(1)
    else:
        continue
