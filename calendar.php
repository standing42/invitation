<?php

date_default_timezone_set('America/Los_Angeles');

$number = 0; 

$time_stamp = time();

class Calendar
{


    public $year;
    public $month;
    public $weeks = array('SUN','MON','TUE','WED','THU','FRI','SAT');
    public $to_day; 

    public $type; 

    public $divide;


    function __construct($options = array()) {
        $this->year = date('Y');
        $this->month = date('m');
        $this->to_day = date('j');
        $this->divide = mktime(0,0,0,$this->month,$this->to_day,$this->year); 
         
        $vars = get_class_vars(get_class($this));
        foreach ($options as $key=>$value) {
            if (array_key_exists($key, $vars)) {
                $this->$key = $value;
            }
        }
    }
     
    function display()
    {
        echo '<div class="calendar">';
        $this->showChangeDate();
        $this->showWeeks();
        $this->showDays($this->year,$this->month);
        echo '</div>';
    }
     
    function showWeeks()
    {
        echo '<div class="">';
        foreach($this->weeks as $title)
        {
            echo '<div class="show_week">' . $title . '</div>';
        }
        echo '</div>';
    }
     
    function showDays($year, $month)
    {
        //Timestamp: first day of this month, 12:00am
        $firstDay = mktime(0, 0, 0, $month, 1, $year); 

        //what day is that day
        $starDay = date('w', $firstDay);

        //number of days in this month
        $days = date('t', $firstDay);
 
        echo '<div class="each_week">';

        for ($i=0; $i<$starDay; $i++)   //print out days from last month
        {
            echo '<div class="no_day">&nbsp;</div>';
        }


        $database = "invitation.db";          

        try  
        {     
            $db = new SQLite3($database);
        }
        catch (Exception $exception)
        {
            echo '<p>There was an error connecting to the database!</p>';
            if ($db)
            {
                echo $exception->getMessage();
            }
        }

        
        $table = "events";

        $field1 = "user";
        $field2 = "type"; 
        $field3 = "date"; 
        $field4 = "location"; 
        $field5 = "event_title"; 

        $sql = "SELECT * FROM $table";
        $result = $db->query($sql);

        


         
        for ($j=1; $j<=$days; $j++)  //days in this month
        {
            $i++; 

            $number++; 

            $temp = 0;

            $expire = mktime(0,0,0,$month, $j, $year); 


            if($expire<$this->divide){

                echo '<div class = "show_day"><p class="date">' . $j . '</p><p class= "display"></p></div>';  //past events are not displayed. 
            }else if ($j == date('d')) {
                
                while($record = $result->fetchArray())
                {
                    $dead = $record[$field3];
                    if($dead>$expire){
                    $temp++;
                    }
                }
                echo '<a href="list.php?date=' . $j . '&month=' . $month . '&year=' . $year . '"><div class = "today"><p class="date_today">' . $j . '</p><p class= "display_today">' . $temp . '</p></div></a>'; //different color for today
           
            } else {
                
                while($record = $result->fetchArray())
                {
                    $dead = $record[$field3];
                    if($dead>$expire){
                    $temp++;
                    }
                }
                
                echo '<a href="list.php?date=' . $j . '&month=' . $month . '&year=' . $year . '"><div class = "today"><p class="date_today">' . $j . '</p><p class= "display_today">' . $temp . '</p></div></a>'; //other days

            }
            if ($i % 7 == 0) {
                echo '</div><div class="each_week">';  //put all days inside div week 
            }
        }

        while($i%7!=0){
            echo '<div class="no_day">&nbsp;</div>'; //print out days from next month
            $i++; 
        }

         
        echo '</div>';
    }
     
    function showChangeDate()
    {
         
        $url = basename($_SERVER['PHP_SELF']);
         
        echo '<div class="">';
        echo '<div class="change_date"></div>';
        echo '<div class="change_date"></div>';

        
        echo '<div class="choose_month"><form>';
         
        echo '<select name="year" onchange="window.location=\'' . $url . '?year=\'+this.options[selectedIndex].value+\'&month=' . $this->month . '\'">';
        for($ye=$this->year; $ye<=2030; $ye++) {
            $selected = ($ye == $this->year) ? 'selected' : '';
            echo '<option ' . $selected . ' value="' . $ye . '">' . $ye . '</option>';
        }
        echo '</select>';
        echo '<select name="month" onchange="window.location=\'' . $url . '?year=' . $this->year . '&month=\'+this.options[selectedIndex].value+\'\'">';
         
        for($mo=1; $mo<=12; $mo++) {
            $selected = ($mo == $this->month) ? 'selected' : '';
            echo '<option ' . $selected . ' value="' . $mo . '">' . $mo . '</option>';
        }
        echo '</select>';        
        echo '</form></div>';  
            
        echo '<div class="change_date"><p><a class="change_month" href="?' . $this->nextMonthUrl($this->year,$this->month) . '">' . '>' . '</a></p></div>';
        echo '<div class="change_date"></div>';        
        echo '</div>';
    }
     
    function preYearUrl($year,$month)
    {
        $year = ($this->year <= 2016) ? 2016 : $year - 1 ;
         
        return 'year=' . $year . '&month=' . $month;
    }
     
    function nextYearUrl($year,$month)
    {
        $year = ($year >= 2030)? 2030 : $year + 1;
         
        return 'year=' . $year . '&month=' . $month;
    }
     
    function preMonthUrl($year,$month)
    {
        if ($month == 1) {
            $month = 12;
            $year = ($year <= 2016) ? 2016 : $year - 1 ;
        } else {
            $month--;
        }        
         
        return 'year=' . $year . '&month=' . $month;
    }
     
    function nextMonthUrl($year,$month)
    {
        if ($month == 12) {
            $month = 1;
            $year = ($year >= 2030) ? 2030 : $year + 1;
        }else{
            $month++;
        }
        return 'year=' . $year . '&month=' . $month;
    }
     
}