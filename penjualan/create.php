<html>
    <body>
        <br/>
        <h3>Penjualan</h3>
        <form action="createaksi.php" method="post" onsubmit="return validasi()">	
            <table>
                <tr>
                    <td>Nomor Invoice</td>
                    <td><input type="number" name="Invoice" id="invoice"></td>					
                </tr>	
                <tr>
                    <td>Nama Pelanggan</td>
                    <td><input type="text" name="Nama" id="nama"></td>					
                </tr>	
                <tr>
                    <td>Tanggal Pembelian</td>
                    <td><input type="date" name="Tgl" id="tgl"></td>					
                </tr>	
            </table>
            <br/>
            <input type="submit" name="save" value="Save">
            <a href="index.php">Back</a>
            <br/>
            <br/>
            <table id="detail" border="1">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Quantity</th>
                        <th>Harga</th>	
                        <th>Aksi</th>
                    </tr>	
                    <tr class="unit-table">
                        <td>
                            <input type="text" name="NamaBarang[]" id="namabarang">
                        </td>
                        <td>
                            <input type="number" name="Qty[]" id="qty">
                        </td>
                        <td>
                            <input type="number" name="Harga[]" id="harga">
                        </td>
                        <td>
                            <button type="button" class="clearButton" onclick="Delrow(this)">-</button>
                        </td>
                    </tr>
                </thead>
            </table>
            <button type="button" id="add_button" onclick="Detail()">+</button>
        </form>
        
        <script>
            function Detail()
            {
                var table = document.getElementById("detail");
                var rows = document.getElementById("detail").rows.length;
                var row = table.insertRow(rows);
                
                var cell1 = row.insertCell(0);
                var namaBarang = document.createElement('input');
                namaBarang.setAttribute('name', 'NamaBarang[]');
                cell1.appendChild(namaBarang);

                var cell2 = row.insertCell(1);
                var qty = document.createElement('input');
                qty.setAttribute('name', 'Qty[]');
                cell2.appendChild(qty);

                var cell3 = row.insertCell(2);
                var harga = document.createElement('input');
                harga.setAttribute('name', 'Harga[]');
                cell3.appendChild(harga);

                var cell4 = row.insertCell(3);
                var button = document.createElement('button');
                button.setAttribute('type', 'button')
                button.setAttribute('onclick', 'Delrow(this)')
                button.innerText = '-'
                cell4.appendChild(button);
            }
            document.getElementById('add_button').onclick=Detail;

            function Delrow(buttonElement)
            {
                buttonElement.closest('tr').remove();
            }
        </script>

        <script>
            function validasi(){
                var invoice = document.getElementById('invoice');
                var nama = document.getElementById('nama');
                var tgl = document.getElementById('tgl');
                var namabarang = document.getElementById('namabarang');
                var qty = document.getElementById('qty');
                var harga = document.getElementById('harga');

                if (val(invoice, "Lengkapi data!")) {
                    if (val(nama, "Lengkapi data!")) {
                        if (val(tgl, "Lengkapi data!")) {
                            if (val(namabarang, "Lengkapi data!")) {
                                if (val(qty, "Lengkapi data!")) {
                                    if (val(harga, "Lengkapi data!")) {
                                        return true;
                                    };
                                };
                            };
                        };
                    };
                };
                return false;
            }
            function val(att, msg){
                if (att.value.length == 0) {
                    alert(msg);
                    att.focus();
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>

    