<style type="text/css">
	input, select, textarea {
		text-transform: UPPERCASE;
		padding: 5px;
	}

</style>

<form id="penjualandelForm">
    <?php
        include('../../db.php');
        $Invoice = $_GET['Invoice'];
        $query = mysqli_query($connect,"SELECT * from penjualan WHERE Invoice='$Invoice'");
        $data = mysqli_fetch_assoc($query);
        $tgl = $data['Tgl'];
        $newtgl = date("d-m-Y", strtotime($tgl));
    ?>
    <table width="100%" cellspacing="0" id="delData">
        <tr>
            <td>
                <label>No.Invoice</label>
            </td>
            <td>
                <input type="text" id="Invoice" name="Invoice" class="FormElement ui-widget-content ui-corner-all" autocomplete="off" readonly autofocus value="<?php echo $data['Invoice'];?>">
            </td>
        </tr>
        <tr>
            <td>
                <label>Nama Customer</label>
            </td>
            <td>
                <input type="text" id="Nama" name="Nama" class="FormElement ui-widget-content ui-corner-all" required autocomplete="off" value="<?php echo $data['Nama'];?>">
            </td>
        </tr>
        <tr>
            <td>
                <label>Tanggal Pembelian</label>
            </td>
            <td>
                <input type="text" id="Tgl" name="Tgl" class="FormElement ui-widget-content ui-corner-all Tgl" required autocomplete="off" maxlength="10" value="<?php echo $newtgl;?>"> 
            </td>
        </tr>
        <tr>
            <td>
                <label>Jenis Kelamin</label>
            </td>
            <td>
                <select id="Jeniskelamin" class="FormElement ui-widget-content ui-corner-all JenisKelamin" name="Jeniskelamin" required value="<?php echo $data['Jeniskelamin'];?>">
                    <option value="1">LAKI-LAKI</option>
                    <option value="2">PEREMPUAN</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Saldo</label>
            </td>
            <td>
                <input type="text" id="Saldo" name="Saldo" class="FormElement ui-widget-content ui-corner-all im-currency" required autocomplete="off" value="<?php echo $data['Saldo'];?>">
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" class="table ui-state-default" cellpading="5" cellspacing="0" id="detailData">
        <thead>
			<tr>
				<th class="ui-th-div">Nama Barang</th>
				<th class="ui-th-div">Qty</th>
				<th class="ui-th-div">Harga</th>
				<th class="ui-th-div">Action</th>
			</tr>
		</thead>
        <tbody>
            <?php
                $querydetail = mysqli_query($connect,"SELECT * from detailpenjualan WHERE Invoice='$Invoice'");
                while($datadetail = mysqli_fetch_assoc($querydetail))
                {
                ?>
                    <tr>
                        <td>
                            <input type="text" name="NamaBarang[]" id="namabarang" class="FormElement ui-widget-content ui-corner-all" required autocomplete="off" value="<?php echo $datadetail['NamaBarang'];?>">
                        </td>
                        <td>
                            <input type="text" name="Qty[]" id="qty" class="FormElement ui-widget-content ui-corner-all im-numeric" required autocomplete="off" value="<?php echo $datadetail['Qty'];?>">
                        </td>
                        <td>
                            <input type="text" name="Harga[]" id="harga" class="FormElement ui-widget-content ui-corner-all im-currency" required autocomplete="off" value="<?php echo $datadetail['Harga'];?>">
                        </td>
                        <td>
                            <a href="javascript:">
                                <span class="ui-icon ui-icon-trash" onclick="$(this).parent().parent().parent().remove()"></span>
                            </a>
                        </td>
                    </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
		let index = 0

		setDateFormat()
		setNumericFormat()
        setSelect2()
        setCustomBindKeys()
        disableInputs()
	})

    function setDateFormat() 
    {
        $('.Tgl').datepicker({
            dateFormat: 'dd-mm-yy'
        }).inputmask({
            inputFormat: "dd-mm-yy"
        })
    }

    function setSelect2()
    {
        $('.JenisKelamin').select2()
    }

    function disableInputs() {
		$('.FormElement').attr('disabled', 'disabled')
	}

    function setNumericFormat() {
        $('.im-numeric').keypress(function(e){
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
            {
                return false;
            }
        })

        $('.im-currency').inputmask('integer', {
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
			digitsOptional: false,
			allowMinus: false,
			placeholder: '',
        })
    }
</script>