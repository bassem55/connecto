<?php 

namespace App\Classes;

use App\Models\User;
use App\Models\friend;
use App\Models\friend_request;
use Auth;
use App\Traits\comman;
use Str;
class search_class 
{
    use comman;
    public function make_search($input)
    {
        $org_data = "";
        $data = [];
        $data_counter = 0;
        if (is_numeric($input))
        {
            //will search in phone numbers

            $num_count = strlen($input);
            if($num_count == 10  || $num_count == 11)
            {
                
                $data_user = User::select('id' , 'name')->where('phone_number' , $input)->get();
                if(count($data_user) > 0)
                {
                    $org_data = $data_user;
                    
                }

            }
        }
        else
        {
            if(strlen($input) <= 50)
            {
                if($this->is_email($input))
                {
                    //search in emails 
                    $data_user = User::select('id' , 'name')->where('email' , $input)->get();
                    if(count($data_user) > 0)
                    {
                        $org_data = $data_user;
                    }
                }
                else
                {
                   
                    //search in names
                    $all_users_names = User::select('id' ,'name')->get();
                    
                    $all_data = [];
                    $all_data_counter = 0;
        
                    foreach($all_users_names as $name)
                    {
                        //compare_with_names function  will check example if i search about bassem and in database user named bassem reda kaiser
                        //so we will compare in full name with (bassem) and (reda) and (kaiser) 

                        if($this->compare_with_names($input , $name->name) == "matched")
                        {
                            $btns = $this->gen_relation_buttons(Auth::id() ,  $name->id);
               
                            $all_data[$all_data_counter] = [
                                 "id" => $name->id ,
                                 "name" => $name->name ,
                                 "relation_1" => $btns['relation_1']  ,
                                 "relation_2" => $btns['relation_2']  ,
                                 "fun_name_1" => $btns['fun_name_1']  ,
                                 "fun_name_2" => $btns['fun_name_2']
                            ];
                            $all_data_counter++;
                        }
                    } 
                    return $all_data;
                } 
            } 
        }

       
        if($org_data != "")
        {
            
            $all_data = [];
            $all_data_counter = 0;
            foreach($org_data as $mini_data)
            {
                
                $btns = $this->gen_relation_buttons(Auth::id() ,  $mini_data['id']);

                $all_data[$all_data_counter] = [
                     "id" => $mini_data->id ,
                     "name" => $mini_data->name ,
                     "relation_1" => $btns['relation_1']  ,
                     "relation_2" => $btns['relation_2']  ,
                     "fun_name_1" => $btns['fun_name_1']  ,
                     "fun_name_2" => $btns['fun_name_2']
                    ];
                    $all_data_counter++;
            }
            return $all_data;
        }
        else
        {
            return $org_data;//null
        }
    }
    private function compare_with_names($name1 , $name2)
    {
        //this functionto compare with names and return if matched or dismatched
        //this function support compare like this $name1 = "bassem" $name2 = "bassem reda kaiser ayoub"
        //will return matched
        $name_1 = Str::lower($name1);
        $name_2 = Str::lower($name2);
        

        $n_name1 = explode(' ' , $name_1);
        $n_name2 = explode(' ' , $name_2);

        if(count($n_name1) == count($n_name2))
        {
            //in this we will do regular compare
            if($name_1 == $name_2)
                return "matched";
            else
                return "mismatched";

        }
        else if(count($n_name1) > 0 && count($n_name2) > 0)
        {
            for($i=0;$i<count($n_name1);$i++)
            {
                for($j=0;$j<count($n_name2);$j++)
                {
                    if($n_name1[$i] == $n_name2[$j])
                    {
                        return "matched";
                    }
                }
            }
            return "mismatched";
        }
        
        return "mismatched";
    }
    private function is_email($input)
    {
        $dd = explode("@" , $input); //if input email dd will equal 2 (2 parts)

        //return $dd;
        if(count($dd) == 2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>