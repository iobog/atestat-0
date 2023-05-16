<!DOCTYPE html>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
    dati numele <input type="text" name="num" required=''><br>
    dati prenumele <input type="text" name="prenum" required=''><br>
    dati media <input type="text" name="med" required=''><br>
    dati clasa <input type="text" name="clas" required=''><br>
    Alege  o imagine de profil:
    <input type="file" name="fis" id="fis"><br>
    <input type="submit" value="Upload fisier" name="submit">
    
</form>
    <form method="post">
    <input type="submit" value="Arata_elevii" name="afis">
</form>

</body>
</html>
<?php
if (isset($_POST['submit']))///UPLOAD
{
    $caleapoza_posibila="imagini/".basename($_FILES["fis"]["name"]);
    if (file_exists($caleapoza_posibila)) {
    echo "Regretam dar un fisier cu acest nume exista deja! Alege alt nume";
    } 
    else
	if ($_FILES['fis']['size']<=1000000000){
	
		//$dir_cr=getcwd();//aflu directorul curent
		//echo $dir_cr;
		///$da=date(j.m.Y);
		if(is_uploaded_file($_FILES['fis']['tmp_name'])){///daca s-a incarcat complet
		move_uploaded_file($_FILES['fis']['tmp_name'],"imagini/".$_FILES['fis']['name']);///mutam fisierul temporar in fisierul imagini cu numele convenabil
		}
		$caleapoza="imagini/".$_FILES['fis']['name'];
		$nume=$_POST['num'];
        $prenume=$_POST['prenum'];
		$media=$_POST['med'];
        $clas=$_POST['clas'];
			$ok = 0;
        include "conectare.php";
        $interogare = "INSERT INTO elevi(nume,prenume,medie,clasa,poza) VALUES('$nume','$prenume','$media','$clas','$caleapoza')";
			if( $error = mysqli_query($id_con,$interogare))
			{
				?>	<script type="text/javascript">
								alert("Elev adaugat!");
 				</script>
             <?php 
			}
			else
			{
					?>	<script type="text/javascript">
								alert("Eroare la INSERT!");
 				</script>
             <?php 
			}
			mysqli_close($id_con);	
			
	}
	else{
	    ?>
				<script type="text/javascript">
								alert("Alegeti un fisier a carui marime sa fie de cel mult 1000 octeti");
 				</script>
			<?php
		
	}
	}
    
        if(isset($_POST["afis"]))///ADUC DIN BD
    {
        include ("conectare.php");
        $sql = "Select * from elevi order by medie DESC";
        
        if ($r=mysqli_query($id_con,$sql)) 
                {
                    if (mysqli_num_rows($r)>0)///daca exista cel putin un elev in setul de date
                    {
                        echo "<table border=1>";
                        echo"<tr> <th>Nume</th> <th>Prenume</th> <th>Clasa</th> <th>Media</th><th>Imagine profil</th> </tr>";
                        while ($linie=mysqli_fetch_array($r))
                            {
                               echo "<tr>";
                              echo "<td>$linie[1]</td> <td>$linie[2]</td> <td> $linie[3] </td> <td>$linie[4]</td><td> <img src='$linie[5]' width='150px' height='100px' ></td>";
                               echo "</tr>";
                            }
                       }
                       else 
                       {
                         echo "Nu exista elevi in tabela!";
                }
                }else 
                {
                    echo "Error: " . $sql . "<br>" . mysqli_error($id_con);
                }
    }
    
?>