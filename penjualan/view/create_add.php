<?php 
    include '../controller/penjualan.php'
?>
<style type="text/css">
	input, select, textarea {
		text-transform: uppercase;
		padding: 5px;
	}

</style>
<form id="penjualanaddForm">
    <!-- <div id="errorBox" class="ui-state-error" cellpadding="5">
        <label>Lengkapi Data !</label>
    </div> -->
    <table width="100%" cellspacing="0" id="addData">
        <tr>
            <td>
                <label>No.Invoice</label>
            </td>
            <td>
                <input type="text" id="Invoice" name="Invoice" class="FormElement ui-widget-content ui-corner-all" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td>
                <label>Nama Customer</label>
            </td>
            <td>
                <input type="text" id="Nama" name="Nama" class="FormElement ui-widget-content ui-corner-all" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td>
                <label>Tanggal Pembelian</label>
            </td>
            <td>
                <input type="text" id="Tgl" name="Tgl" class="FormElement ui-widget-content ui-corner-all Tgl" required autocomplete="off" maxlength="10">
            </td>
        </tr>
        <tr>
            <td>
                <label>Jenis Kelamin</label>
            </td>
            <td>
                <select id="Jeniskelamin" class="FormElement ui-widget-content ui-corner-all" name="Jeniskelamin" required></select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Saldo</label>
            </td>
            <td>
                <input type="text" id="Saldo" name="Saldo" class="FormElement ui-widget-content ui-corner-all im-numeric" required autocomplete="off">
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
            <tr>
                <td>
                    <input type="text" name="NamaBarang[]" id="namabarang" class="FormElement ui-widget-content ui-corner-all" required autocomplete="off">
                </td>
                <td>
                    <input type="text" name="Qty[]" id="qty" class="FormElement ui-widget-content ui-corner-all im-numeric" required autocomplete="off">
                </td>
                <td>
                    <input type="text" name="Harga[]" id="harga" class="FormElement ui-widget-content ui-corner-all im-currency" required autocomplete="off">
                </td>
                <td>
					<a href="javascript:">
						<span class="ui-icon ui-icon-trash" onclick="$(this).parent().parent().parent().remove()"></span>
					</a>
				</td>
            </tr>
            <tr>
				<td colspan="3"></td>
				<td>
					<a href="javascript:" onclick="addRow(); setNumericFormat(); formBindKeys();">
						<span class="ui-icon ui-icon-plus"></span>
					</a>
				</td>
			</tr>
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
		let index = 0

		setDateFormat()
		setNumericFormat()
		formBindKeys()
	})

    function addRow()
    {
        $('#detailData tbody tr').last().before(`
            <tr>
                <td>
                    <input type="text" name="NamaBarang[]" class="FormElement ui-widget-content ui-corner-all" required autocomplete="off">
                </td>
                <td>
					<input type="text" name="Qty[]" class="FormElement ui-widget-content ui-corner-all im-currency" required autocomplete="off">
				</td>
				<td>
					<input type="text" name="Harga[]" class="FormElement ui-widget-content ui-corner-all im-numeric" required autocomplete="off">
				</td>
                <td>
					<a href="javascript:">
						<span class="ui-icon ui-icon-trash" onclick="$(this).parent().parent().parent().remove()"></span>
					</a>
				</td>
            </tr>
        `)
    }

    function setDateFormat() 
    {
        $('.Tgl').datepicker({
            dateFormat: 'dd-mm-yy'
        }).inputmask({
           //mask: "1-2-y",
            inputFormat: "dd-mm-yy",
            //separator: "-",
            alias: "datetime",
            
        })
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

        $.ajax({
            url: 'Jeniskelamin()',
            type: 'GET',
            dataType : 'JSON',
            success: function(res) 
            {
                res.forEach(function(el, i) {
                    $('#Jeniskelamin').append(`
                        <option value="${el.id_Jeniskelamin}">${el.Jeniskelamin}</option>
                    `)
                    $('#Jeniskelamin').select2()
                })
            }
        })
    }

    

    function formBindKeys() {
		let inputs = $('#penjualanaddForm [name]:not(:hidden)')
		let element
		let position

		inputs.each(function(i, el) {
			$(el).attr('data-input-index', i)
		})

		$(inputs[0]).focus()

		inputs.focus(function() {
			$(this).data('input-index')
		})

		inputs.keydown(function(e) {
			let operator
			switch(e.keyCode) {
				case 38:
					element.hasClass('Tgl')
						? $('.ui-datepicker').show()
						: $('.ui-datepicker').hide()
					break
				case 40:
					element.hasClass('Tgl')
						? $('.ui-datepicker').show()
						: $('.ui-datepicker').hide()
					break
			}
		})
	}
</script>