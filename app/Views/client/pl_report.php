<?= $this->extend('client/layout/template') ?>

<?= $this->section('content') ?>

<div class="content">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert bg-success text-white alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            <span class="font-weight-semibold">Well done!</span> Ticket Successfully Created! <a href="#" class="alert-link"></a>
        </div>
    <?php endif ?>

    <?php
    $no = 1;
    ?>
    <div class="card text-right">
        <div class="card-body">
            <?php if (!empty($file)) : ?>
                <a href="<?= base_url('files/' . $file->file) ?>" download="<?= $file->file ?>" class=" btn btn-teal"><i class="icon-file-download mr-2"></i> Download Report</a>
                <!-- <button type="button" class="btn btn-teal"><i class="icon-file-download mr-2"></i>Download Report</button> -->
            <?php endif ?>

        </div>
    </div>
    <div class="row">
        <?php if ($plReport->getNumRows() > 0) : ?>
            <?php foreach ($plReport->getResultArray() as $row) : ?>
                <div class="col-xl-6">
                    <!-- Multi level donut chart -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><?= strtoupper($row['chart']) ?> </h5>
                        </div>

                        <div class="card-body">

                            <div class="chart-container">
                                <?php
                                $data = array($row['jan'], $row['feb'], $row['mar'], $row['apr'], $row['may'], $row['jun'], $row['jul'], $row['aug'], $row['sep'], $row['oct'], $row['nov'], $row['dec']);
                                $chartData = json_encode($data);
                                $chartId = "viz_" . $no;
                                $no++;
                                ?>
                                <div class="chart has-fixed-height" id="<?= $chartId ?>"></div>

                                <script type="text/javascript">
                                    var nameData = [],
                                        valueData = [],
                                        foregroundColor = '#1990FF',
                                        backgroundColor = '#f5f5f5';
                                    // Initialize the echarts instance based on the prepared dom
                                    var myChart = echarts.init(document.getElementById('<?= $chartId ?>'));
                                    // Specify the configuration items and data for the chart
                                    option = {
                                        textStyle: {
                                            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                                            fontSize: 11
                                        },
                                        tooltip: {
                                            trigger: 'axis',
                                            axisPointer: {
                                                type: 'shadow'
                                            }
                                        },
                                        grid: {
                                            left: '3%',
                                            right: '4%',
                                            bottom: '3%',
                                            containLabel: true
                                        },
                                        xAxis: [{
                                            type: 'category',
                                            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                            axisTick: {
                                                alignWithLabel: true
                                            },

                                        }],
                                        yAxis: [{
                                            type: 'value',

                                            axisLabel: {
                                                <?php if ($row['type'] == "percentage") : ?>
                                                    formatter: '{value}%'
                                                <?php elseif ($row['type'] == "currency") : ?>
                                                    formatter: '$ {value}'
                                                <?php else : ?>
                                                    formatter: '{value}'
                                                <?php endif ?>

                                            }
                                        }],
                                        series: [{
                                            name: 'Direct',
                                            type: 'bar',
                                            data: <?= $chartData ?>,

                                            label: {
                                                <?php if ($row['type'] == "percentage") : ?>
                                                    show: true,
                                                    formatter: '{c}%'
                                                <?php elseif ($row['type'] == "currency") : ?>
                                                    show: true,
                                                    formatter: '$ {c}'
                                                <?php else : ?>
                                                    show: true,
                                                <?php endif ?>
                                            },

                                            itemStyle: {
                                                color: foregroundColor,
                                                barBorderRadius: 0
                                            },
                                            z: 10,
                                            showBackground: false,
                                            backgroundStyle: {
                                                barBorderRadius: 0,
                                                color: backgroundColor
                                            },

                                        }]
                                    };

                                    // Display the chart using the configuration items and data just specified.
                                    myChart.setOption(option);
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- /multi level donut chart -->

                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <!-- /blocks with chart -->

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>/assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="<?= base_url() ?>/assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>/assets/js/demo_pages/datatables_basic.js"></script>


<?= $this->endSection() ?>