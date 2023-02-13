<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" media="screen" href="../jqGrid/css/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../jqGrid/css/trirand/ui.jqgrid.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="../jqGrid/js/trirand/i18n/grid.locale-en.js" type="text/javascript"></script>
        <script src="../jqGrid/js/trirand/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>
        <script src="https://unpkg.com/autonumeric"></script>

        <title>Penjualan</title>
    </head>
    <body>
        <div class="container">
            <form action="" method="post">
                <table id="grid_id"></table>
                <div id="jqGridPager"></div>
            </form>  
        </div>
        <script> 
            let currentSearch

            $(document).ready(function () 
            {
                $("#grid_id").jqGrid(
                {
                    caption: 'Penjualan',
                    datatype: 'json',
                    url: '../api.php',
                    styleUI: 'jQueryUI',
                    width: 850,
                    height: 'auto',
                    pageable: true,
                    viewrecords: true,
                    rowNum: 10,
                    rownumbers: true,
                    autoencode: true,
                    sortable: true,
                    pager : '#jqGridPager',
                    editurl: 'save.php',
                    colNames: ['ID', 'No. Invoice', 'Nama Customer', 'Tanggal Pembelian', 'Jenis Kelamin', 'Saldo'],
                    colModel: 
                    [
                        {
                            name: 'Id',
                            sortable: true,
                            hidden: true,
                            key: true,
                            editable: true
                        },
                        {
                            name: 'Invoice',
                            index: 'Invoice',
                            sortable: true,
                            editable: true,
                            editoptions:
                            {
                                dataInit: function(element) 
                                {
                                    $(element).attr('autocomplete', 'off'),
                                    $(element).css('text-transform', 'uppercase')
                                }
                            },
                            searchoptions: 
                            {
                                dataInit: function(element) 
                                {
                                    $(element).attr('autocomplete', 'off')
                                },
                                sopt: ["in","ge","le"] 
						    }
                        },
                        {
                            name: 'Nama',
                            index: 'Nama',
                            sortable: true,
                            editable: true,
                            editoptions:
                            {
                                dataInit: function(element) 
                                {
                                    $(element).attr('autocomplete', 'off'),
                                    $(element).css('text-transform', 'uppercase')
                                }
                            },
                            searchoptions: 
                            {
                                dataInit: function(element) 
                                {
                                    $(element).attr('autocomplete', 'off')
                                }
						    }
                        },
                        {
                            name: 'Tgl',
                            index: 'Tgl',
                            sortable: true,
                            editable: true,
                            editoptions:
                            {
                                dataInit: function(element) 
                                {
                                    $(element).attr('autocomplete', 'off'),
                                    $(element).css('text-transform', 'uppercase'),
                                    $(element).datepicker(
                                        {
                                            dateFormat: 'dd-mm-yy'
                                        }
                                    ),
                                    $(element).inputmask("date",
                                        {
                                            mask: "1-2-y",
                                            separator: "-",
                                            alias: "d-m-y"
                                        }
                                    )
                                }
                            },
                            formatter: 'date',
                            formatoptions: 
                            { 
                                newformat: 'd-m-Y'
                            },
                            sorttype:'date',
                            searchoptions: 
                            {
                                dataInit: function(element)
                                {
                                    $(element).attr('autocomplete', 'off')
                                }
						    }
                        },
                        {
                            name: 'Jeniskelamin',
                            index: 'Jeniskelamin',
                            sortable: true,
                            editable: true,
                            edittype: 'select',
                            editoptions:
                            {
                                value: 'Laki-Laki:LAKI-LAKI;Perempuan:PEREMPUAN',
                                dataInit: function(element) 
                                {
                                    $(element).select2(),
                                    $(element).css('text-transform', 'uppercase')
                                }
                            },
                            searchoptions: 
                            {
                                dataInit: function(element)
                                {
                                    $(element).attr('autocomplete', 'off')
                                }
						    }
                        },
                        {
                            name: 'Saldo',
                            index: 'Saldo',
                            sortable: true,
                            align: 'right',
                            editable: true,
                            editoptions:
                            {
                                dataInit: function(element) 
                                {
                                    element.style.textAlign = 'right',
                                    $(element).attr('autocomplete', 'off'),
                                    new AutoNumeric(element,
                                    {
                                        currencySymbol : ' ',
                                        decimalCharacter : ',',
                                        digitGroupSeparator : '.'
                                    })
                                }
                            },
                            formatter:'currency',
                            formatoptions:
                            {
                                thousandsSeparator: ".",
                                decimalSeparator: ",",
                                decimalPlaces : 2,
                                prefix : 'Rp ',  
                                deaultValue: "Rp 0.00",
                            },
                            searchoptions: 
                            {
                                dataInit: function(element)
                                {
                                    $(element).attr('autocomplete', 'off')
                                }
						    }
                        }
                    ],
                    jsonReader: 
                    {
                        root: 'data',
                        id: 'Id',
                        repeatitems: false
                    },
                    loadComplete: function() 
                    {
                        $(document).unbind('keydown')
			            customBindKeys()

                        setTimeout(function()
                        {
                            $('#gsh_grid_id_rn')
                            .html(`
                                <button type="button" id="clearFilter" title="Clear Filter" style="width: 100%; height: 100%;"> X </button>
                            `).click(function() 
                            {})
                        }) 
                    }
                });
                var source =
                {
                    beforeprocessing: function(data)
                    {		
                        source.totalrecords = data[0].TotalRows;
                    }
                };
                jQuery("#grid_id").jqGrid('filterToolbar', 
                {
                    autosearch: true,
                    searchOnEnter: false,
                    stringResult: true,
                    ignoreCase: true,
                    defaultSearch: 'cn', 
                    groupOp: 'AND',
                }), 
                // jQuery("#grid_id").jqGrid('navButtonAdd',"#jqGridPager",
                // {
                //     caption:"Clear",
                //     title:"Clear",
                //     id : "clearFilter",
                //     buttonicon: "ui-icon-plus",
                //     onClickButton:function()
                //     {
                //         activeGrid = undefined
                //         clearFilter()
                //     }
                // }),
                jQuery("#grid_id").jqGrid('navGrid', '#jqGridPager', null,
                {
                    recreateForm: true,
                    beforeShowForm: function(form) 
                    { 
                      $('#Invoice').attr('readonly','readonly');
                    },
                    serializeRowData: function(postData)
                    {
                        postData.Invoice = postData.Invoice.toUpperCase();
                        postData.Nama = postData.Nama.toUpperCase();
                        postData.Tgl = postData.Tgl.toUpperCase();
                        postData.Jeniskelamin = postData.Jeniskelamin.toUpperCase();
                        postData.Saldo = postData.Saldo.toUpperCase();
                        return postData;
                    }
                }, {
                    recreateForm: true
                }),
                // jQuery("#grid_id").jqGrid('bindKeys', 
                // {
                    
                // });

                $(document).on('click','#clearFilter',function()
                {
                    currentSearch = undefined
                    $('[id*="gs_"]').val('')
                    $('#grid_id').jqGrid('setGridParam', {postData: null})
                    $('#grid_id').jqGrid('setGridParam',
                    {
                        postData: 
                        {
                            page: 1,
                            rows: 10,
                            sidx: 'Invoice',
                            sord: 'asc',
                        },
                    })
                    .trigger('reloadGrid')
                });
            });
            
            function customBindKeys() 
            {
                $(document).keydown(function(e) {
                    if (
                    e.keyCode == 38 ||
                    e.keyCode == 40 ||
                    e.keyCode == 33 ||
                    e.keyCode == 34 ||
                    e.keyCode == 35 ||
                    e.keyCode == 36
                    ) {
                    e.preventDefault();

                        if ('#grid_id' !== undefined) {
                        var gridArr = $('#grid_id').getDataIDs();
                        var selrow = $('#grid_id').getGridParam("selrow");
                        var curr_index = 0;
                        var currentPage = $('#grid_id').getGridParam('page')
                            var lastPage = $('#grid_id').getGridParam('lastpage')
                            var row = $('#grid_id').jqGrid('getGridParam', 'postData').rows

                        for (var i = 0; i < gridArr.length; i++) {
                            if (gridArr[i] == selrow) curr_index = i;
                        }

                        switch (e.keyCode) {
                            case 33:
                            if (currentPage > 1) {
                                $('#grid_id').jqGrid('setGridParam', { "page": currentPage - 1 }).trigger('reloadGrid')
                            }
                                    break
                                case 34:
                            if (currentPage !== lastPage) {
                                $('#grid_id').jqGrid('setGridParam', { "page": currentPage + 1 }).trigger('reloadGrid')
                            }
                            case 38:
                                if (curr_index - 1 >= 0)
                            $('#grid_id')
                                .resetSelection()
                                .setSelection(gridArr[curr_index - 1])
                            break
                            case 40:
                                if (curr_index + 1 < gridArr.length)
                            $('#grid_id')
                                .resetSelection()
                                .setSelection(gridArr[curr_index + 1])
                                break
                            }
                        }
                    }
                })
            }
        </script>
    </body>
</html>