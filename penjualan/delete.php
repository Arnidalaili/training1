<html>
    <body>
        <h3>Delete</h3>
        <form action="deleteaksi.php" method="post">
            <?php
                include('../db.php');
                $Invoice = $_GET['Invoice'];
                $sql = mysqli_query($connect,"SELECT * from penjualan WHERE Invoice='$Invoice'");
                while($data=mysqli_fetch_array($sql)) 
                {
            ?>
                <table>
                    <tr>
                        <td><input type="hidden" id="invoice" name="Invoice" value="<?php echo $data['Invoice'];?>"></td>					
                    </tr>	
                    <tr>
                        <td><input type="submit" name="delete" value="Delete"></td>	
                    </tr>
                </table>
            <?php
                }
            ?>	
        </form>
    </body>
</html>



















