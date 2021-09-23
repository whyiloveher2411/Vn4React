import { Grid, makeStyles } from '@material-ui/core';
import React from 'react';
import { useSelector } from 'react-redux';
import addScript from 'utils/addScript';
import Channel from './components/Insights/Channel';
import Order from './components/Insights/Order';
import ReportsSales from './components/Insights/ReportsSales';
import ReturnRate from './components/Insights/ReturnRate';
import Revenue from './components/Insights/Revenue';
import Reviews from './components/Insights/Reviews';

const useStyles = makeStyles((theme) => ({
    root:{
        '& svg>g>g>g:nth-child(1) rect': {
            fill: theme.palette.divider + ' !important',
        },
    },
    titlePanel: {
        color: theme.palette.grey.A200,
        fontWeight: 'normal', marginBottom: 8,
        fontSize: 15
    },
    valuePanel: {
        marginBottom: 8,
        fontSize: 26
    },
}
));

function Insights() {

    const classes = useStyles();
    const theme = useSelector(state => state.theme);

    const [data, setData] = React.useState(false);

    React.useEffect(() => {

        setTimeout(() => {

            addScript("https://www.gstatic.com/charts/loader.js", 'googleCharts', () => {

                setData(true);

                window.google.charts.load('current', { packages: ['corechart', 'line'] });
                window.google.charts.setOnLoadCallback(drawBasic);

                function drawBasic() {

                    if (document.getElementById('chart_reports_sales')) {
                        let data = new window.google.visualization.DataTable();
                        data.addColumn('number', 'X');
                        data.addColumn('number', 'Dogs');

                        data.addRows([
                            [0, 0], [1, 10], [2, 23], [3, 17], [4, 18], [5, 9],
                            [6, 11], [7, 27], [8, 33], [9, 40], [10, 32], [11, 35],
                            [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
                            [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
                            [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
                            [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
                            [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
                            [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
                            [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
                            [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
                            [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
                            [66, 70], [67, 72], [68, 75], [69, 80]
                        ]);

                        let options = {
                            backgroundColor: 'transparent',
                            legend: { textStyle: { color: theme.palette.text.secondary } },
                            hAxis: {
                                title: 'Time',
                                titleTextStyle: {
                                    color: theme.palette.text.secondary
                                },
                                textStyle: {
                                    color: theme.palette.text.secondary
                                }
                            },
                            vAxis: {
                                title: 'Popularity',
                                titleTextStyle: {
                                    color: theme.palette.text.secondary
                                },
                                textStyle: {
                                    color: theme.palette.text.secondary
                                }
                            }
                        };

                        let chart = new window.google.visualization.LineChart(document.getElementById('chart_reports_sales'));

                        chart.draw(data, options);
                    }




                    if (document.getElementById('chart_channel')) {
                        let data = new window.google.visualization.DataTable();
                        data.addColumn('string', 'Pizza');
                        data.addColumn('number', 'Populartiy');
                        data.addRows([
                            ['Pepperoni', 33],
                            ['Hawaiian', 26],
                            ['Mushroom', 22],
                            ['Sausage', 10], // Below limit.
                            ['Anchovies', 9] // Below limit.
                        ]);

                        let options = {
                            title: 'Popularity of Types of Pizza',
                            backgroundColor: 'transparent',
                            sliceVisibilityThreshold: .2,
                            fontSize: 13,
                            pieHole: 0.5,
                            pieSliceBorderColor: 'transparent',
                            chartArea: {
                                height: 300,
                                width: 400
                            },
                            legend: { textStyle: { color: theme.palette.text.secondary } },
                        };

                        let chart = new window.google.visualization.PieChart(document.getElementById('chart_channel'));
                        chart.draw(data, options);
                    }


                    if (document.getElementById('chart_return_rate')) {
                        let data = new window.google.visualization.DataTable();
                        data.addColumn('string', 'Pizza');
                        data.addColumn('number', 'Populartiy');
                        data.addRows([
                            ['Pepperoni', 33],
                            ['Hawaiian', 26],
                            ['Mushroom', 22],
                            ['Sausage', 10], // Below limit.
                            ['Anchovies', 9] // Below limit.
                        ]);

                        let options = {
                            title: 'Popularity of Types of Pizza',
                            backgroundColor: 'transparent',
                            sliceVisibilityThreshold: .2,
                            fontSize: 13,
                            pieSliceBorderColor: 'transparent',
                            chartArea: {
                                height: 300,
                                width: 400
                            },
                            legend: { textStyle: { color: theme.palette.text.secondary } },
                        };

                        let chart = new window.google.visualization.PieChart(document.getElementById('chart_return_rate'));
                        chart.draw(data, options);
                    }


                    if (document.getElementById('chart_reviews')) {
                        let data = window.google.visualization.arrayToDataTable([
                            ['Element', 'Count'],
                            ['x5', 19],
                            ['x4', 15],
                            ['x3', 8],
                            ['x2', 7],
                            ['x1', 2]
                        ]);
                        let options = {
                            title: "Density of Precious Metals, in g/cm^3",
                            backgroundColor: 'transparent',
                            titleTextStyle: { color: theme.palette.text.secondary },
                            width: '100%',
                            height: 277,
                            bar: { groupWidth: '95%' },
                            legend: { position: 'none' },
                            fontSize: 13,
                            hAxis: {
                                textStyle: {
                                    color: theme.palette.text.secondary
                                }
                            },
                            vAxis: {
                                textStyle: {
                                    color: theme.palette.text.secondary
                                }
                            },
                            chartArea: {
                                left: 20,
                                width: '100%'
                            }
                        };
                        let chart = new window.google.visualization.BarChart(document.getElementById('chart_reviews'));
                        chart.draw(data, options);
                    }
                }

            });
        }, 2000);
    }, []);

    return (
        <Grid container spacing={3} className={classes.root}>
            <Grid item md={4} xs={12}>
                <Grid container spacing={3}>
                    <Grid item md={12} xs={12}>
                        <Revenue data={data} classes={classes} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Order data={data} classes={classes} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Reviews data={data} classes={classes} />
                    </Grid>
                </Grid>
            </Grid>
            <Grid item md={8} xs={12}>
                <Grid container spacing={3}>
                    <Grid item md={12} xs={12}>
                        <ReportsSales data={data} />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <Channel data={data} />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <ReturnRate data={data} />
                    </Grid>
                </Grid>
            </Grid>
        </Grid>
    )
}

export default Insights

