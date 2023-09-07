<?php
    $con = mysqli_connect("localhost","root","","voting") or die("Not connected");

    session_start();
    $user_id = $_SESSION['cdmi'];

    $qry = "SELECT * FROM `reg` WHERE `id` = '$user_id' ";
    $res = mysqli_query($con,$qry);
    $row = mysqli_fetch_assoc($res);
    // print_r($row['name']);

   

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/all.min.css">
	 <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.green.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    
<section>
    <div class="container-fluid p-0 mb-2 img">
        <div class="container doc p-5">
            <h3>Online Voting System</h3>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class=" container-fluid p-0 m-0 img">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4 text text-center my-auto">
                    <a href="">GO VOTE</a>
                </div>
                <div class="col-md-8 p-0 doc">
                    <ul class="row m-0 justify-content-right ">
                        <li class="p-5"><a href="index.php" class="text-white ">Home</a></li>
                        <li class="p-5"><a href="logout.php" class="text-white">Logout</a></li>
                        <li class="p-5"></li>
                        <li class="p-5"></li>
                        <li class=" my-2 p-4"><img src="image/<?php echo $row['image']; ?>" width="50px" height="50px"></li>
                        <li class=" my-4 text-white" style="font-size:20px">
                            <?php echo $row['name'];
                                    echo "<br>";
                                
                                $q = "SELECT * FROM `reg` WHERE `id` = '$user_id'";
                                $r = mysqli_query($con, $q);
                                $rr = mysqli_fetch_assoc($r);
                                $status= $rr['status'];
                                // print_r($status);die;
                                if($status == 1)
                                {
                                    echo "Already Voted";
                                }
                                ?> 
                            <?php   if(isset($_GET['vote']))
                                {
                                    // echo "ok";
                                    $vote_id = $_GET['vote'];
                                    $qry = "SELECT * FROM `candidates` WHERE `id`='$vote_id'";
                                    $res = mysqli_query($con,$qry);
                                    // print_r($res);die;
                                    $row = mysqli_fetch_assoc($res);
                                    $vote = $row['vote'];
                                    // print_r($vote);die;
                                    $totalvotes = $vote +1;
                                    $cnt = mysqli_num_rows($res);
                                    $qry = "UPDATE `candidates` SET `vote` = '$totalvotes' WHERE `id`='$vote_id'";
                                    mysqli_query($con , $qry);
                                    if($cnt == 1 )
                                    {
                                        $qry = "UPDATE `reg` SET `status`='1' WHERE `id`='$user_id' ";
                                        // echo $qry;die;
                                        mysqli_query($con , $qry);
                                        header("location:vote.php");
                                    }
                                }
                                  
                               
                            ?></li>
                    </ul>   
                </div>
            </div>
        </div>
    </div>
</section>


<section class="mx-3">
    <table border="1" width="100%" class="text-center"> 
        <tr style="font-size:20px;">
            <th>Sr. No.</th>
            <th>Image</th>
            <th>Name</th>
            <th>Position</th>
            <th>Vote</th>
        </tr>
        <tr>
            <?php
             $q = "SELECT * FROM `candidates` ";
             $r = mysqli_query($con,$q);
         
                while(@$rr = mysqli_fetch_assoc($r))
                {
                    ?>
                    <tr style="font-weight:500;">
                        <td><?php echo $rr['id']; ?></td>
                        <td><img src="image/<?php echo $rr['image']; ?>" width="100px" height="100px"></td>
                        <td><?php echo $rr['cname']; ?></td>
                        <td><?php echo $rr['name']; ?></td>
                       
                                <td><button class="button"<?php if(@$row['status']=='1'){ ?> disabled <?php } ?>><a  href="index.php?vote=<?php echo $rr['id']; ?>"> Vote </a></button></td>
                            
                        
                    </tr>
            <?php    }
            ?>
            
        </tr>
    </table>
    </section>


</body>
</html>