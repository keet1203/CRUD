<?php

require_once("db.php");
require_once("component.php");


$con=Createdb();
//create btn click

if(isset($_POST['create'])){
   createData();
}
//updt btn click
if(isset($_POST['update'])){
    updateData();
}

//del btn click
if(isset($_POST['delete'])){
    deleteData();
}
//del all
if(isset($_POST['deleteall'])){
    deleteAll();
}


function createData(){
    $boookname=textboxValue("book_name") ;
     $boookpublisher=textboxValue("book_publisher") ;
      $boookprice=textboxValue("book_price") ;

      if($boookname && $boookpublisher && $boookprice){
        $sql="INSERT INTO books(book_name,book_publisher,book_price)
                VALUES('$boookname','$boookpublisher','$boookprice')";

                if(mysqli_query($GLOBALS['con'],$sql)){
                     TextNode("success","Provide successfully inserted");
                }else{
                        echo"ERROR";
                }
      }else{
            TextNode("error","Provide data in Textbox");
      }
}


function textboxValue($value){
    $textbox=mysqli_real_escape_string($GLOBALS['con'],trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox; 
    }
    
}

//msg

function TextNode($classname,$msg){

    $element="<h6 class='$classname'>$msg</h6>";
    echo $element;
}

//get data from db

function getData(){
    $sql="SELECT * FROM books";

   $result= mysqli_query($GLOBALS['con'],$sql);

   if(mysqli_num_rows($result)>0){
       return $result;
   }
}


//update

function updateData(){
    $bookid=textboxValue("book_id");
    $bookname=textboxValue("book_name");
    $bookpublisher=textboxValue("book_publisher");
    $bookprice=textboxValue("book_price");


    if($bookname && $bookpublisher && $bookprice){
        $sql="
            UPDATE books SET book_name='$bookname', book_publisher='$bookpublisher', book_price='$bookprice' WHERE id='$bookid'
        ";
        if(mysqli_query($GLOBALS['con'],$sql)){
            TextNode("success","DATA SUCCESSFULLY UPDATED");
        }else{
            TextNode("error","UNABLE to UPDATE"); 
        }
    }else
        {
         TextNode("error","select DATA USING EDIT ICON");
    }


}

//del

function deleteData(){
    $bookid=(int)textboxValue("book_id");
    $sql="DELETE FROM books WHERE id=$bookid";
    if(mysqli_query($GLOBALS['con'],$sql)){
            TextNode("success","DATA DELETED SUCCESSFULLY");
        }else{
            TextNode("error","UNABLE TO DELETE");
        
        }
}


function delBtn(){
    $result=getData();
    $i=0;
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $i++;
            if($i>3){
                buttonElement("btn-deleteall","btn btn-danger","<i class='fas fa-trash</i>Delete All", "deleteall","");
                return;
            }
    
        }
    }
}

function deleteAll(){
    $sql= "DROP TABLE books";
                if(mysqli_query($GLOBALS['con'],$sql)){
            TextNode("success","ALL DATA DELETED SUCCESSFULLY");
            Createdb();
        }else{
            TextNode("error","NOT DELETED");
        }

}