import { Skeleton } from '@material-ui/lab';
import React from 'react'
import { useSelector } from 'react-redux';

function Map({ data, google, filter }) {

    const theme = useSelector(state => state.theme);
    React.useLayoutEffect(() => {

        if (data && google.charts) {

            google.charts.load('current', {
                'packages': ['table', 'corechart', 'geochart'], callback: function () {

                    if (data.region) {

                        let dataChart = new google.visualization.DataTable();
                        dataChart.addColumn('number', 'Lat');
                        dataChart.addColumn('number', 'Long');
                        dataChart.addColumn('string', 'City');
                        dataChart.addColumn('number', 'Active Users');
                        dataChart.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                        dataChart.addRows(data.rt_country);

                        let opts = {
                            region: data.region,
                            displayMode: 'markers',
                            backgroundColor: 'transparent',
                            defaultColor: 'rgb(227, 123, 51)',
                            legend: 'none',
                            animation: {
                                duration: 1000,
                                easing: 'out',
                            },
                            // legend:{textStyle: {color: 'blue', bold:true, fontSize: 16}},
                            tooltip: { isHtml: true },
                            sizeAxis: { minValue: 0, maxSize: 22 },
                            colorAxis: { colors: ['rgb(227, 123, 51)', 'rgb(227, 123, 51)'] }
                        };

                        if (!window.charts.rt_country) {
                            window.charts.rt_country = new google.visualization.GeoChart(document.getElementById('rt_country'));
                        }

                        window.charts.rt_country.draw(dataChart, opts);

                    } else {

                        let dataChart = new google.visualization.DataTable();
                        dataChart.addColumn('string', 'Country');
                        dataChart.addColumn('number', 'Active Users');
                        dataChart.addRows(data.rt_country);
                        let options = {
                            legend: 'none',
                            backgroundColor: theme.type === 'dark' ? 'transparent' : 'rgb(234, 247, 254)',
                        };
                        function myClickHandler() {
                            let selection = window.charts.rt_country.getSelection();

                            let str = '';

                            for (let i = 0; i < selection.length; i++) {
                                let item = selection[i];
                                if (item.row != null && item.column != null) {
                                    str = dataChart.getFormattedValue(item.row, item.column);
                                } else if (item.row != null) {
                                    str = dataChart.getFormattedValue(item.row, 0);
                                } else if (item.column != null) {
                                    str = dataChart.getFormattedValue(0, item.column);
                                }
                            }

                            if (str !== filter[0]) {
                                filter[1](str);
                            }
                        }

                        if (!window.charts.rt_country) {
                            window.charts.rt_country = new google.visualization.GeoChart(document.getElementById('rt_country'));
                        }

                        google.visualization.events.addListener(window.charts.rt_country, 'select', myClickHandler);

                        window.charts.rt_country.draw(dataChart, options);
                    }


                }
            });
        }

    }, [data]);

    if (!data) {
        return (
            <Skeleton style={{ height: 450, width: '100%', margin: 0, transform: 'scale(1, 1)' }} animation="wave" />
        );
    }

    return (
        <div>
            {
                filter[0] &&
                <span onClick={() => filter[1]('')} style={{ cursor: 'pointer', display: 'inline-block', width: 'auto', background: '#4d90fe', fontSize: '13px', margin: '0 3px 0 0', padding: '7px 10px', WebkitBorderRadius: '2px', color: 'white', backgroundImage: '-webkit-linear-gradient(top,#4d90fe,#4787ed)', lineHeight: '1em', whiteSpace: 'nowrap', position: 'absolute', zIndex: 1 }}>COUNTRY: {filter[0]} <strong style={{ color: 'white' }}>X</strong></span>
            }
            <div id="rt_country" style={{ height: 450 }}></div>
        </div>
    )
}

export default Map
