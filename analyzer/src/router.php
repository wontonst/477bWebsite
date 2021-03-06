<?php

class Router {
    
    
    private static $currentDest;
    private static $currentCur;
    private static $currentPaths;
    private static $choice;
    private static $currentDist;
    private static $currentValid;
    
    private static $currentMin;
    private static $currentMinDist;
    
    public static function shortestPath(&$car, &$start) {
        
        session_start();
        $con=mysql_connect("localhost","four","password");
        if (!$con) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        else{
            if ( !mysql_select_db("477b"))
            {
                echo "Can't connect to 477b";
            }
        }
        
        $check = mysql_query("SELECT routing_type FROM runs WHERE user_id='".$_SESSION['user_id']."' AND name = '".$_SESSION['selection']."'");
        $row = mysql_fetch_row($check);
        $algorithm=$row[0];
        return array_reverse(Router::optimal($car->destination, $start, $algorithm));
    }

    public static function dfs(&$dest, &$cur) {
        if ($cur == $dest) {
            return array($dest);
        }
        $cur->discovered = true;
        foreach ($cur->connections as &$conn) {
            if ($conn->discovered == false) {
                $a = Router::dfs($dest, $conn->end);
                if ($a) {
                    $a[] = $cur;
                    return $a;
                }
            }
        }
        return null;
    }
    
    public static function allDfs(&$dest, &$cur) {
        if ($cur->id == $dest->id) {
            $cur->discovered = true;
            return array(array($dest));
        }
        if($cur->discovered == true)
            return null;
        $list = array();
        $holder;
        $cur->discovered = true;
        foreach ($cur->connections as &$conn) {
            if ($conn->discovered == false) {
                $a = Router::allDfs($dest, $conn->end);
                if ($a) {
                    for($i = 0;$i < count($a);$i++)
                    {
                        $holder = $a[$i];
                        $holder[] = $cur;
                        $a[$i] = $holder;
                        $list[] = $a[$i];
                    }
                }
            }
        }
        $cur->discovered = false;
        if(count($list) != 0)
        {
            return $list;
        }
        return null;
    }
    
    public static function getLength(&$path)
    {
        $count = 0;
        for($i = 1;$i < count($path);$i++){
            for($j = 0;$j < count($path[$i-1]->connections);$j++)
            {
                if($path[$i-1]->connections[$j]->end->id == $path[$i]->id)
                {
                    $count+=$path[$i-1]->connections[$j]->distance;
                    break;
                }
            }
        }
        return $count;
    }
    
    public static function optimal(&$dest, &$cur, $algorithm)
    {
        if(Router::$currentCur == $cur->id && $dest->id == Router::$currentDest)
        {
            $list = Router::$currentPaths;
            $distances = Router::$currentDist;
            $valid = Router::$currentValid;
            
            $valid = Router::$currentValid;
            $min = Router::$currentMin;
            $minDist = Router::$currentMinDist;
        }
        else
        {
            $list = Router::allDfs($dest, $cur);
            Router::$currentPaths = $list;
            Router::$currentCur = $cur->id;
            Router::$currentDest = $dest->id;
            
            $distances = array();
            $valid = array();
            $min = -1;
            $minDist = 0;
            for($i = 0;$i < count($list);$i++)
            {
                $distances[$i] = Router::getLength(array_reverse($list[$i]));
                if($distances[$i] < $minDist || $minDist ==0)
                {
                    $min = $i;
                    $minDist = $distances[$i];
                }
            }
            
            Router::$currentDist = $distances;
            Router::$currentValid = $valid;
            Router::$currentMin = $min;
            Router::$currentMinDist = $minDist;
            
            
        }
    
        
        $sum = 0;
        for($i = 0;$i < count($distances);$i++)
        {
            if($minDist *1.2 >= $distances[$i])
            {
                $valid[$i] = true;
                $sum += ($minDist/$distances[$i]);
            }
            else
            {
                $valid[$i] = false;
            }
        }

        if($algorithm == 1)
        {
            $entry = $list[$min];
            return $entry;
        }
        $rand = rand()/getrandmax();
        $i = -1;
        while($rand >= 0)
        {
            $i++;
            if($valid[$i])
            {
                $rand-=(($minDist/$distances[$i])/$sum);
            }
        }
        $entry = $list[$i];//$min
        $list = null;
        return $entry;
    }

}
?>