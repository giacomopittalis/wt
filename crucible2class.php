<?php
    include 'dbclass.php';
    class crucible2 extends db{
        
        public function inscru(){
            $ret = FALSE;
            
            $data = $this->getdata();
            
            $clid = 8;
            $locid = 36;
            $mname = "";
            $gender = "";
            $htype = "";
            $imgpath = $this->encode("images/noimage.jpg");
            $hplan = "";
            $status = $this->encode("active");
            
            $dbhandle = $this->dbhandle();
            if ($dbhandle){
                $dbfound = $this->dbfound();
                if ($dbfound){
                    $tablename = "employee";
                    $tex = $this->tex($tablename);
                    if ($tex){
                        foreach ($data as $value){
                            $fname = $this->encode($value['fname']);
                            $lname = $this->encode($value['lname']);
                            $dob = $this->encode($value['dob']);
                            $dept = $this->encode($value['dept']);
                            $hyear = $this->encode($value['hyear']);
                            $pos = $this->encode($value['pos']);
                            $desg = $this->encode($value['desg']);
                            
                            $sql = "INSERT INTO `$this->db`.`$tablename` (
                                `id`,
                                `clid`, 
                                `locid`,  
                                `fname`, 
                                `mname`, 
                                `lname`, 
                                `dob`, 
                                `gender`, 
                                `dept`, 
                                `pos`, 
                                `desg`, 
                                `type`, 
                                `hyear`, 
                                `imgpath`, 
                                `hplan`,
                                `status`
                            )
                            VALUES(
                                NULL, 
                                '$clid', 
                                '$locid', 
                                '$fname', 
                                '$mname', 
                                '$lname', 
                                '$dob', 
                                '$gender', 
                                '$dept', 
                                '$pos', 
                                '$desg', 
                                '$htype', 
                                '$hyear', 
                                '$imgpath', 
                                '$hplan',
                                '$status'
                            )";
                            $result = mysql_query($sql, $dbhandle);
                            if ($result){
                                $ret = TRUE;
                            }
                        }
                    }
                }
            }
            return $ret;
        }
        
        public function getdata(){
            
            $data = array();
            
            $dbhandle = $this->dbhandle();
            if ($dbhandle){
                $dbfound = $this->dbfound();
                if ($dbfound){
                    $tablename = "crucibletwo";
                    $tex = $this->tex($tablename);
                    if ($tex){
                        $sql = "SELECT * FROM `$this->db`.`$tablename`";
                        $result = mysql_query($sql, $dbhandle);
                        if ($result){
                            if (mysql_num_rows($result) > 0){
                                $i = 0;
                                while ($resarr = mysql_fetch_assoc($result)){
                                    $data[$i]['fname'] = $resarr['First Name'];
                                    $data[$i]['lname'] = $resarr['Last Name'];
                                    $data[$i]['dob'] = $resarr['DOB'];
                                    $data[$i]['hyear'] = $this->getyear($resarr['DOH']);
                                    $data[$i]['dept'] = $resarr['Department'];
                                    $data[$i]['pos'] = $resarr['Job title'];
                                    $data[$i]['desg'] = $resarr['EID'];
                                    
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
            return $data;
        }
        
        public function getyear($date){
            $ret = "";
            
            $datarr = explode("/", $date);
            
            $ret = $datarr[2];
            
            return $ret;
        }
        
    }
?>