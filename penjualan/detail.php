<html>
    <body>
        <h3>Detail Penjualan</h3>
        <form>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Quantity</th>
                        <th>Harga</th>				
                    </tr>
                <?php
                    include('../db.php');
                    $Invoice = $_GET['Invoice'];
                    $sqli=mysqli_query($connect, "SELECT * FROM detailpenjualan WHERE Invoice='$Invoice'");
                    while($data=mysqli_fetch_array($sqli))
                    {
                ?>	
                <tr class="unit-table">
                    <td>
                        <input type="text" name="NamaBarang[]" readonly value="<?php echo $data['NamaBarang'];?>">
                    </td>
                    <td>
                        <input type="number" name="Qty[]" readonly value="<?php echo $data['Qty'];?>">
                    </td>
                    <td>
                        <input type="number" name="Harga[]" readonly value="<?php echo $data['Harga'];?>">
                    </td>
                </tr>
                <?php
                    }
                ?>
                </thead>
            </table>
            <br/>
            <a href="index.php">Back</a>
        </form>
    </body>
</html>