import React from 'react'
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
    root: {
        '& #chart_location svg>g>g>g:nth-child(3) rect': {
            display: 'none'
        }
    },
}));



function Country({ google, dataGA }) {

    const classes = useStyles();

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
                        title: "",
                        width: '100%',
                        height: '100%',
                        bars: 'horizontal',
                        chartArea: { right: 15, top: 0, bottom: 15 },
                        colors: ['rgb(66, 133, 244)'],
                        bar: { groupWidth: '65%' },
                        hAxis: { minValue: 0, format: "#'%'", gridlines: { count: 4, color: '#ebebeb' } },
                        vAxis: { gridlines: { color: '#ebebeb' }, textStyle: { fontSize: 13, color: '#9e9e9e' } },
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
            <div style={{ color: 'rgba(0,0,0,0.54)' }}>Sessions by country</div>
            <div id="chart_country" style={{ height: 206 }}>

            </div>
            <div id="chart_location" style={{ height: 180 }}>

            </div>
        </div>
    )
}

export default Country
