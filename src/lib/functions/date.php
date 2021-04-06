<?php
/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */


###########################################
# stellt Klassen zur Verfügung, um mit Datum und Zeit umzugehen
#
# class c_date      Datum; Anzahl Tage seit 1.1.2000
# class c_time      Zeit; Anzahl Minuten seit 00:00
# class c_datetime  Verknüpfung der beiden obigen
#
# Achtung: Alle Berechnungen werden immer in der GMT durchgeführt und gespeichert (Ortsunabhängig)
#          Beim Verwenden von ortsabhängigen Funktionen wie z.B. time() muss unbedingt daran gedacht werden
#

class c_date
{
    public $m_days = 0;	// Anzahl vergangene Tage seit dem 1.1.2000  (1.1.2000 => 0)
  
    # function setManual( $day, $month, $year )
    # function setUnix( $timestamp )
    # function setString( $string )
  
    # function getUnix()
    # function getString( $format )
    # function getValue()
    # function getDay()
    # function getMonth()
    # function getYear()
  
    // Datum manuell setzen
    public function setDay2000($day)
    {
        $this->m_days = $day;
        return $this;
    }
  
    public function setManual($day, $month, $year)
    {
        $this->setUnix(gmmktime(0, 0, 0, $month, $day, $year));
        return $this;
    }
  
    // Datum mittels eines Unix-Timestamp setzen
    public function setUnix($timestamp)
    {
        $tmp = $timestamp -  gmmktime(0, 0, 0, 1, 1, 2000);
        $this->m_days = floor($tmp/60/60/24);
        return $this;
    }
  
    // Datum mittels eines Strings im Format 01.11.2007 setzen
    public function setString($string)
    {
        preg_match("/([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", $string, $regs);
        $this->setUnix(gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]));
        return $this;
    }
  
    // Unix-Timestamp zurückgeben
    public function getUnix()
    {
        return $this->m_days*24*60*60 + gmmktime(0, 0, 0, 1, 1, 2000);
    }
  
    // String im Format $format zurückgeben
    public function getString($format)
    {
        return gmdate($format, $this->getUnix());
    }
  
    // Wert $m_days zurückgeben
    public function getValue()
    {
        return $this->m_days;
    }

    // Montatstag zurückgeben
    public function getDay()
    {
        return gmdate("j", $this->getUnix());
    }
  
    public function getDayName()
    {
        $change = array(
                
                "Mon" => "Montag",
                "Tue" => "Dienstag",
                "Wed" => "Mittowch",
                "Thu" => "Donnerstag",
                "Fri" => "Freitag",
                "Sat" => "Samstag",
                "Sun" => "Sonntag"
                );
     
     
        return $change[gmdate("D", $this->getUnix())];
    }
  
    public function getDayShortName()
    {
        $change = array(
                
                "Mon" => "Mo",
                "Tue" => "Di",
                "Wed" => "Mi",
                "Thu" => "Do",
                "Fri" => "Fr",
                "Sat" => "Sa",
                "Sun" => "So"
                );
     
     
        return $change[gmdate("D", $this->getUnix())];
    }
        
                   
    // Monat zurückgeben
    public function getMonth()
    {
        return gmdate("n", $this->getUnix());
    }
  
    // Jahr zurückgeben
    public function getYear()
    {
        return gmdate("Y", $this->getUnix());
    }
}

class c_time
{
    public $m_min;   // Anzahl vergangene Minuten seit Mitternacht 00:00 (Maximalwert: 1439)
  
    # function setManual( $hour, $min )
    # function setUnix( $timestamp )
    # function setString( $string )
  
    # function getUnix()
    # function getString( $format )
    # function getValue()
    # function getHour()
    # function getMin()
  
    // Uhrzeit manuell setzen
    public function setManual($hour, $min)
    {
        $this->m_min = $hour*60 + $min;
        return $this;
    }
  
    // Uhrzeit mittels eines Unix-TImestamps setzen
    public function setUnix($timestamp)
    {
        $this->m_min = floor($timestamp / 60) % 1440;
        return $this;
    }
  
    // Uhrzeit mittels eines Strings im Format 12:54/12.54/12 54/1254 setzen
    public function setString($string)
    {
        if (!preg_match("/([0-9]{1,2})[.: ]+([0-9]{1,2})/", $string, $regs) && strlen($string) == 4) {
            preg_match("/([0-9]{1,2})([0-9]{1,2})/", $string, $regs);
        }
    
        $this->setManual($regs[1], $regs[2]);
        return $this;
    }
  
    public function setValue($min)
    {
        $this->m_min = $min;
        return $this;
    }
  
  
    // Unix-Offset für Zeit zurückgeben
    public function getUnix()
    {
        return $this->m_min*60;
    }
  
    public function getString($format)
    {
        return gmdate($format, $this->getUnix());
    }
  
    public function getValue()
    {
        return $this->m_min;
    }
  
    public function getMin()
    {
        return $this->m_min % 60;
    }
  
    public function getHour()
    {
        return floor($this->m_min/60);
    }
}

class c_datetime
{
    public $m_time;
    public $m_date;
  
    # function setManual( $day, $month, $year, $hour, $min )
    # function setUnix( $timestamp )
    # function setString( $string )
  
    # function getUnix()
    # function getString( $format )
    # function getValue()
    # function getDay()
    # function getMonth()
    # function getYear()
    # function getHour()
    # function getMin()
  
    public function __construct()
    {
        $this->m_time = new c_time;
        $this->m_date = new c_date;
    }
  
    public function setManual($day, $month, $year, $hour, $min)
    {
        $this->m_date->setManual($day, $month, $year);
        $this->m_time->setManual($hour, $min);
    }
  
    public function setUnix($timestamp)
    {
        $this->m_date->setUnix($timestamp);
        $this->m_time->setUnix($timestamp);
    }
  
    public function setString($string) // Interpretiert einen String im Format "1.11.2007 12:54"
    {
        # Todo: String aufbrechen
        $this->m_date->setString($str1);
        $this->m_time->setString($str2);
    }
  
    public function getUnix()
    {
        return $this->m_date->getUnix() + $this->m_time->getUnix();
    }
  
    public function getString($format)  // String im Format $format zurückgeben
    {
        return gmdate($format, $this->getUnix());
    }

    public function getDay()
    {
        $this->m_date->getDay();
    }
    public function getMonth()
    {
        $this->m_date->getMonth();
    }
    public function getYear()
    {
        $this->m_date->getYear();
    }
    public function getHour()
    {
        $this->m_time->getHour();
    }
    public function getMin()
    {
        $this->m_time->getMin();
    }
  
    public function getDayName()
    {
        return $this->m_date->getDayName();
    }
  
    public function getDayShortName()
    {
        return $this->m_date->getDayShortName();
    }
}
