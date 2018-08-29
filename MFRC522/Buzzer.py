import RPi.GPIO as GPIO   #import the GPIO library
import time               #import the time library

class Buzzer(object):

 def __init__(self, pin):
  GPIO.setmode(GPIO.BOARD)  
  self.buzzer_pin = pin  #set to GPIO pin
  GPIO.setup(self.buzzer_pin, GPIO.OUT)

 def buzz(self, pitch, duration):   #create the function buzz and feed it the pitch and duration)
 
  if(pitch==0):
   time.sleep(duration)
   return
  period = 1.0 / pitch     #in physics, the period (sec/cyc) is the inverse of the frequency (cyc/sec)
  delay = period / 2     #calcuate the time for half of the wave  
  cycles = int(duration * pitch)   #the number of waves to produce is the duration times the frequency

  for i in range(cycles):    #start a loop from 0 to the variable cycles calculated above
   GPIO.output(self.buzzer_pin, True)   #set pin 18 to high
   time.sleep(delay)    #wait with pin 18 high
   GPIO.output(self.buzzer_pin, False)    #set pin 18 to low
   time.sleep(delay)    #wait with pin 18 low

 def play(self, frequency, count, duration, sleep):
  GPIO.setmode(GPIO.BOARD)
  GPIO.setup(self.buzzer_pin, GPIO.OUT)

  for p in range(count):
    self.buzz(frequency, duration)  #feed the pitch and duration to the function, buzz
    time.sleep(duration * sleep)
