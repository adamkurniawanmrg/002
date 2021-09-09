<?php
                // API E-GOV UNTUK HANDLE REQUEST DATA ROLE
                
                $DB_USER        = 'INSERT_HERE_YOUR_DATABASE_USER';
                $DB_PASS        = 'INSERT_HERE_YOUR_DATABASE_PASSWORD';
                $DB_NAME        = 'INSERT_HERE_YOUR_DATANASE_NAME';
                
                $this_user_key  = '9d332-c8bf58cec3bb4ae81068e785d8f09ce9';
                $this_user_pass = '9d862453b5';
                
            
                if(isset($_POST['user_key']) && isset($_POST['pass_key'])){
                    extract($_POST);
                    if($user_key!=$this_user_key || $pass_key!=$this_user_pass){
                        echo json_encode([
                            'alert'     => ['class'    => 'danger', 'capt'     => '<strong>Error</strong> Api key tidak valid, silahkan coba lagi!']
                        ]);
                        exit();
                    }
                    $k = new mysqli('localhost', $DB_USER, $DB_PASS, $DB_NAME);
            
                    if($method=='get'){
                        $role = $k->query("SELECT * FROM tb_role ORDER BY 'id' DESC");
                        $data = array();
                        foreach($role as $r){
                            $data[] = $r;
                        }
                        echo json_encode([
                            'data'      => $data,
                        ]);
            
                    }else if($method=='getone'){
                        $role = $k->query("SELECT * FROM tb_role WHERE role_id='$role_id\'");
                        echo json_encode([
                            'data'      => mysqli_fetch_array($role),
                        ]);
                        
                    }
                    exit();    
                }
                
                echo json_encode([
                    'alert'     => ['class'    => 'danger', 'capt'     => 'Api key tidak valid, silahkan coba lagi!']
                ]);
            