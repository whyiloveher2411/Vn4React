import React from 'react'
import { makeStyles } from '@material-ui/core/styles';
import { useSelector } from 'react-redux';

const useStyles = makeStyles((theme) => ({
    root: {
        '& #chart_location svg>g>g>g:nth-child(3) rect': {
            display: 'none'
        },
        '& #chart_location svg>g>g>g:nth-child(1) rect': {
            fill: theme.palette.divider + ' !important',
        }
    },
    title: {
        color: theme.palette.text.secondary,
    }
}));



function Country({ google, dataGA }) {

    const classes = useStyles();

    const theme = useSelector(state => state.theme);

    React.useEffect(() => {

        if (dataGA && google.charts) {

            google.charts.load('current', {
                'packages': ['corechart', 'geochart'], callback: function () {

                    let dataInitial = [
                        ['Country', 'Sessions']
                    ];

                    dataGA.general.session_country.rows.forEach((e, k) => {
                        dataInitial.push([e[0], e[1] * 1]);
                    });

                    let data = google.visualization.arrayToDataTable(dataInitial);
                    let options = {
                        backgroundColor: 'transparent',
                        colorAxis: { minValue: 0, colors: ['rgb(207, 225, 241)', 'rgb(47, 94, 196)'] },
                        legend: 'none',
                        height: '100%',
                        magnifyingGlass: { enable: true, zoomFactor: 5.0 },
                    };
                    let chart = new google.visualization.GeoChart(document.getElementById('chart_country'));
                    chart.draw(data, options);




                    // LOCATION
                    let dataInitial2 = [
                        ['Country', 'Sessions', { role: 'tooltip' }]
                    ];

                    dataGA.general.session_country.rows.forEach((e, k) => {

                        if (k > 5) {
                            return;
                        }

                        dataInitial2.push([
                            e[0],
                            e[1] * 100 / (dataGA.general.session_country.totalsForAllResults['ga:sessions'] !== 0 ? dataGA.general['session_country'].totalsForAllResults['ga:sessions'] : 1),
                            "SESSIONS\n" + e[0] + ' ' + (e[1] * 100 / (dataGA.general.session_country.totalsForAllResults['ga:sessions'] !== 0 ? dataGA.general.session_country.totalsForAllResults['ga:sessions'] : 1)).toFixed(2) + '%'
                        ]);
                    });

                    let data2 = google.visualization.arrayToDataTable(dataInitial2);


                    let formatter = new google.visualization.NumberFormat({ pattern: '#%' });
                    formatter.format(data2, 1);

                    let options2 = {
                        backgroundColor: 'transparent',
                        title: "",
                        width: '100%',
                        height: '100%',
                        bars: 'horizontal',
                        chartArea: { right: 15, top: 0, bottom: 15 },
                        colors: ['rgb(66, 133, 244)'],
                        bar: { groupWidth: '65%' },
                        hAxis: { minValue: 0, format: "#'%'", textStyle: { fontSize: 12, color: theme.palette.text.secondary }, gridlines: { count: 4, color: theme.palette.text.divider } },
                        vAxis: {
                            textStyle: { fontSize: 13, color: theme.palette.text.secondary }
                        },
                        orientation: 'vertical',
                        legend: { position: 'none' },
                    };
                    let chart2 = new google.visualization.BarChart(document.getElementById('chart_location'));
                    chart2.draw(data2, options2);
                }
            });
        }

    }, [dataGA]);

    return (
        <div className={classes.root}>
            <div className={classes.title}>Sessions by country</div>
            <div id="chart_country" style={{ height: 206 }}>

            </div>
            <div id="chart_location" style={{ height: 180 }}>

            </div>
        </div>
    )
}

export default Country
