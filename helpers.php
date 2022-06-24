<?php 

function Clean($input){

     return  trim(strip_tags(stripslashes($input)));
}


  function Validate($input,$flag){

    $status = true;

     switch ($flag) {
         case 1:
         
             if (empty($input)) {
                $status = false;
             }
             break;
      
        case 2: 
        
         if (!filter_var($input, FILTER_VALIDATE_EMAIL)){
            $status = false;
         } 
          break;


        case 3: 
       
           if (strlen($input) < 6){
               $status = false;
           }  
           break;


           case 4: 
            
            $allowedExt = ['png','jpg','jpeg']; 
                 if(!in_array($input,$allowedExt)){
                    $status = false;
                 }
            break;  


            case 5: 
               
               if(!preg_match('/^[a-zA-Z\s]*$/',$input)){
                  $status = false;
               }
               break;
 


     }

     return $status;

  }



   function Errors($errors){
    foreach ($errors as $key => $value) {
       
            echo '* ' . $key . ' : ' . $value . '<br>';
        }

   }



?>