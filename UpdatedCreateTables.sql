CREATE TABLE Airport (
airportcode VARCHAR(3),
airportname VARCHAR(50),
country VARCHAR(32),
PRIMARY KEY (airportcode)
);

CREATE TABLE FlightInfo(
flightnum VARCHAR(6),
infotype CHAR(1) CHECK(infotype = 'A' or infotype = 'D'),
dateFlight date,
timeFlight timestamp,
gatenumber VARCHAR(3),
terminalnum INTEGER,
airportcode VARCHAR(3) NOT NULL,
FOREIGN KEY (airportcode) REFERENCES Airport(airportcode),
PRIMARY KEY (flightnum)
);

CREATE TABLE FlightClass(
classtype VARCHAR(9),
flightnum VARCHAR(6) NOT NULL,
price NUMERIC,
capacity INTEGER,
FOREIGN KEY (flightnum) REFERENCES FlightInfo(flightnum),
PRIMARY KEY (classtype,flightnum)
);

CREATE TABLE Passenger(
pid NUMBER NOT NULL,
pname VARCHAR(50),
pcontact INTEGER,
pemail VARCHAR(50),
PRIMARY KEY (pid)
);

CREATE SEQUENCE S_Passenger
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE OR REPLACE TRIGGER T_Passenger_pid
BEFORE INSERT
ON Passenger
REFERENCING NEW AS NEW
FOR EACH ROW
BEGIN
  if(:new.pid is null) then
  SELECT S_Passenger.nextval
  INTO :new.pid
  FROM dual;
  end if;
END;
/

ALTER TRIGGER T_Passenger_pid ENABLE;

CREATE TABLE Booking (
bookingid NUMBER,
pid NUMBER,
FOREIGN KEY (pid) REFERENCES Passenger(pid),
PRIMARY KEY (bookingid)
);

CREATE TABLE Ticket (
tid NUMBER,
seatnum VARCHAR(3),
flightnum VARCHAR(6) NOT NULL,
classtype VARCHAR(9) NOT NULL,
pid NUMBER,
bookingid NUMBER,
FOREIGN KEY (classtype,flightnum) REFERENCES FlightClass(classtype,flightnum),
FOREIGN KEY (pid) REFERENCES Passenger(pid),
FOREIGN KEY (bookingid) REFERENCES Booking(bookingid),
PRIMARY KEY (tid)
);
