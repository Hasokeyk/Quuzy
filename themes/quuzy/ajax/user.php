<?php 

    if(isset($action,$type,$user) and $action == 'userSave'){

        $results = userSave(json_decode($_POST['user']),$type);
        $results = userPostSave(json_decode($_POST['user']),$type);
        if($results){
            $results = [
                'status' => 'success'
            ];
        }else{
            $results = [
                'status' => 'danger'
            ];
        }
        

    }else if(isset($action,$type,$user) and $action == 'userPostSave'){

        $results = userSave(json_decode($_POST['user']),$type);
        $results = userPostSave(json_decode($_POST['user']),$type);
        if($results){
            $results = [
                'status' => 'success'
            ];
        }else{
            $results = [
                'status' => 'danger'
            ];
        }
        
    }else{
        $results = [
            'status' => 'danger',
            'message' => 'Parametre Hatası',
        ];
    }

    echo json_encode($results);