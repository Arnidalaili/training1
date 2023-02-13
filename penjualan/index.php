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
            let activeGrid = '#grid_id'

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
                })
                .keyControl(),

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

                        if (activeGrid !== undefined) {
                        var gridArr = $(activeGrid).getDataIDs();
                        var selrow = $(activeGrid).getGridParam("selrow");
                        var curr_index = 0;
                        var currentPage = $(activeGrid).getGridParam('page')
                            var lastPage = $(activeGrid).getGridParam('lastpage')
                            var row = $(activeGrid).jqGrid('getGridParam', 'postData').rows

                        for (var i = 0; i < gridArr.length; i++) {
                            if (gridArr[i] == selrow) curr_index = i;
                        }

                        switch (e.keyCode) {
                            case 33:
                            if (currentPage > 1) {
                                $(activeGrid).jqGrid('setGridParam', { "page": currentPage - 1 }).trigger('reloadGrid')
                            }
                                    break
                                case 34:
                            if (currentPage !== lastPage) {
                                $(activeGrid).jqGrid('setGridParam', { "page": currentPage + 1 }).trigger('reloadGrid')
                            }
                            case 38:
                                if (curr_index - 1 >= 0)
                            $(activeGrid)
                                .resetSelection()
                                .setSelection(gridArr[curr_index - 1])
                            break
                            case 40:
                                if (curr_index + 1 < gridArr.length)
                            $(activeGrid)
                                .resetSelection()
                                .setSelection(gridArr[curr_index + 1])
                                break
                            }
                        }
                    }
                })
            }

            $.fn.keyControl = function (e) 
            {
            var l = $.extend(
                {
                onEnter: null,
                onSpace: null,
                onLeftKey: null,
                onRightKey: null,
                scrollingRows: !0,
                },
                e || {}
            )
            return this.each(function () {
                var s = this

                $("body").is("[role]") || $("body").attr("role", "application"),
                (s.p.scrollrows = l.scrollingRows),
                $(s)
                    .on("keydown", function (e) {
                    var t,
                        i,
                        r = $(s).find("tr[tabindex=0]")[0],
                        o = s.p.treeReader.expanded_field

                    if (r) {
                        var n = s.p.selrow,
                        a = s.p._index[$.jgrid.stripPref(s.p.idPrefix, r.id)]
                                var currentPage = $(s).getGridParam('page')
                                    var lastPage = $(s).getGridParam('lastpage')
                                    var row = $(this).jqGrid('getGridParam', 'postData').rows

                        if (
                        33 === e.keyCode ||
                        34 === e.keyCode ||
                        35 === e.keyCode ||
                        36 === e.keyCode ||
                        37 === e.keyCode ||
                        38 === e.keyCode ||
                        39 === e.keyCode ||
                        40 === e.keyCode
                        ) {
                            if (33 === e.keyCode) {
                                triggerClick = true
                                if (currentPage > 1) {
                                    $(s).jqGrid('setGridParam', { "page": currentPage - 1 }).trigger('reloadGrid')
                                }
                            $(s).triggerHandler("jqGridKeyUp", [t, n, e]),
                            $(this).isFunction(l.onUpKey) && l.onUpKey.call(s, t, n, e),
                            e.preventDefault()
                        }
                            if (34 === e.keyCode) {
                                triggerClick = true
                                if (currentPage !== lastPage) {
                                    $(s).jqGrid('setGridParam', { "page": currentPage + 1 }).trigger('reloadGrid')
                                }
                            $(s).triggerHandler("jqGridKeyUp", [t, n, e]),
                            $(this).isFunction(l.onUpKey) && l.onUpKey.call(s, t, n, e),
                            e.preventDefault()
                        }
                        if (35 === e.keyCode) {
                            triggerClick = true
                            if (currentPage !== lastPage) {
                                $(s).jqGrid('setGridParam', { "page": lastPage}).trigger('reloadGrid')
                                if (e.ctrlKey) {
                                    if ($(s).jqGrid('getGridParam', 'selrow') !== $('#grid_id').find(">tbody>tr.jqgrow").filter(":last").attr('id')) {
                                        $(s).jqGrid('setSelection', $(s).find(">tbody>tr.jqgrow").filter(":last").attr('id')).trigger('reloadGrid')
                                    }
                                }
                            }
                            if (e.ctrlKey) {
                                if ($(s).jqGrid('getGridParam', 'selrow') !== $('#grid_id').find(">tbody>tr.jqgrow").filter(":last").attr('id')) {
                                    $(s).jqGrid('setSelection', $(s).find(">tbody>tr.jqgrow").filter(":last").attr('id')).trigger('reloadGrid')
                                }
                            }
                            $(s).triggerHandler("jqGridKeyUp", [t, n, e]),
                            $(this).isFunction(l.onUpKey) && l.onUpKey.call(s, t, n, e),
                            e.preventDefault()
                        }
                        if (36 === e.keyCode) {
                            triggerClick = true
                            if (e.ctrlKey) {
                                if ($(s).jqGrid('getGridParam', 'selrow') !== $('#grid_id').find(">tbody>tr.jqgrow").filter(":first").attr('id')) {
                                    $(s).jqGrid('setSelection', $(s).find(">tbody>tr.jqgrow").filter(":first").attr('id'))
                                }
                            }
                                $(s).jqGrid('setGridParam', { "page": 1}).trigger('reloadGrid')
                            $(s).triggerHandler("jqGridKeyUp", [t, n, e]),
                            $(this).isFunction(l.onUpKey) && l.onUpKey.call(s, t, n, e),
                            e.preventDefault()
                        }
                        if (38 === e.keyCode) 
                        {
                            
                            $(s).triggerHandler("jqGridKeyUp", [t, n, e]),
                            $(this).isFunction(l.onUpKey) && l.onUpKey.call(s, t, n, e),
                            e.preventDefault()
                        }
                        if (40 === e.keyCode) 
                        {
                            $(s).triggerHandler("jqGridKeyDown", [t, n, e]),
                            $(this).isFunction(l.onDownKey) &&
                                l.onDownKey.call(s, t, n, e),
                            e.preventDefault()
                        }
                        37 === e.keyCode &&
                            (s.p.treeGrid &&
                            s.p.data[a][o] &&
                            $(r).find("div.treeclick").trigger("click"),
                            $(s).triggerHandler("jqGridKeyLeft", [s.p.selrow, e]),
                            $(this).isFunction(l.onLeftKey) &&
                            l.onLeftKey.call(s, s.p.selrow, e)),
                            39 === e.keyCode &&
                            (s.p.treeGrid &&
                                !s.p.data[a][o] &&
                                $(r).find("div.treeclick").trigger("click"),
                            $(s).triggerHandler("jqGridKeyRight", [s.p.selrow, e]),
                            $(this).isFunction(l.onRightKey) &&
                                l.onRightKey.call(s, s.p.selrow, e))
                        } else
                        13 === e.keyCode
                            ? ($(s).triggerHandler("jqGridKeyEnter", [s.p.selrow, e]),
                            $(this).isFunction(l.onEnter) &&
                                l.onEnter.call(s, s.p.selrow, e))
                            : 32 === e.keyCode &&
                            ($(s).triggerHandler("jqGridKeySpace", [s.p.selrow, e]),
                            $(this).isFunction(l.onSpace) &&
                                l.onSpace.call(s, s.p.selrow, e))
                    }
                    })
                    .on("click", function (e) {
                    $(e.target).is("input, textarea, select") ||
                        $(e.target, s.rows).closest("tr.jqgrow").focus()
                    })
                })
            }
            $.fn.isFunction = function (e) 
            {
                return "function" == typeof e
            }
        </script>
    </body>
</html>