<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Penjualan Report</title>
        <link rel="stylesheet" type="text/css" href="stimulsoft-report\2021.03.06\css\stimulsoft.viewer.office2013.whiteblue.css"/>
        <link rel="stylesheet" type="text/css" href="stimulsoft-report\2021.03.06\css\stimulsoft.designer.office2013.whiteblue.css"/>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.reports.js"></script>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.viewer.js"></script>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.dashboards.js"></script>
        <script type="text/javascript" src="stimulsoft-report\2021.03.06\scripts\stimulsoft.designer.js"></script>
        <script type="text/javascript">
        
        Start();
        afterPrint();
            function Start()
            {
                var viewer = new Stimulsoft.Viewer.StiViewer(null, "StiViewer", false)
                var report = new Stimulsoft.Report.StiReport()

                var options = new Stimulsof.Designer.StiDesignerOptions()
                options.appearance.fullScreenMode = transliterator_create_from_rules
                var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
                var dataSet = new Stimulsoft.System.Data.DataSet("Data")

                viewer.renderHtml('content')
                report.loadFile('./reports/penjualan.mrt')

                report.dictionary.dataSources.clear()

                dataSet.readJson(<?php echo json_encode($penjualan) ?>)

                report.regData(dataSet.dataSetName, '', dataSet)
                report.dictionary.synchronize()

                viewer.report = report
                designer.renderHtml("content")
                designer.report = Report
            }

            function afterPrint()
            {
                if (confirm('Tutup halaman ?'))
                {
                    window.close()
                }
            }
        </script>
        <style type="text/css">
            .stiJsViewerPage 
            {
                word-break: break-all
            }
        </style>
    </head>
    <body onLoad="Start()" onafterprint="afterPrint()">
        <div id="content"></div>
    </body>
</html>