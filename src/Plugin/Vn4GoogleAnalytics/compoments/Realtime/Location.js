import { Skeleton } from '@material-ui/lab';
import React from 'react'

function Location({ classStyle, data, google, filter }) {

    React.useEffect(() => {

        if (data && google.charts) {

            google.charts.load('current', {
                'packages': ['table', 'corechart', 'geochart'], callback: function () {

                    if (data.region) {

                        window.charts.region = data.region;


                        let dataChart = new google.visualization.DataTable();
                        dataChart.addColumn('string', 'City');
                        dataChart.addColumn('number', '');
                        dataChart.addColumn('number', 'Active Users', { 'width': '50px' });
                        dataChart.addRows(data.rt_location);
                        if (document.getElementById('rt_location')) {
                            if (!window.charts.rt_location) {
                                window.charts.rt_location = new google.visualization.Table(document.getElementById('rt_location'));
                            }
                            window.charts.rt_location.draw(dataChart, { showRowNumber: true, allowHtml: true, width: '100%' });
                        }

                    } else {

                        window.charts.region = false;

                        let dataChart = new google.visualization.DataTable();
                        dataChart.addColumn('string', 'Country');
                        dataChart.addColumn('number', '');
                        dataChart.addColumn('number', 'Active Users', { 'width': '50px' });
                        dataChart.addRows(data.rt_location);
                        if (document.getElementById('rt_location')) {
                            if (!window.charts.rt_location) {
                                window.charts.rt_location = new google.visualization.Table(document.getElementById('rt_location'));
                            }
                            window.charts.rt_location.draw(dataChart, { showRowNumber: true, allowHtml: true, width: '100%' });
                        }
                        google.visualization.events.addListener(window.charts.rt_location, 'select', function () {
                            if (!window.charts.region) {
                                let selection = window.charts.rt_location.getSelection();
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
                        });


                    }
                }
            });
        }

    }, [data]);

    if (!data) {
        return (
            <div>
                <h3 className={classStyle.titleTop} > <Skeleton style={{ height: 16, width: '100%', marginBottom: '2px', transform: 'scale(1, 1)' }} animation="wave" /></h3>
                {
                    [0, 1, 2, 3, 4, 5].map((i) => (
                        <div key={i} style={{ display: 'flex', margin: '0 -2px' }}>
                            <Skeleton style={{ height: 22, width: '10%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '35%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '20%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '35%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                        </div>
                    ))
                }
            </div>
        );
    }


    return (
        <div>
            <h3 className={classStyle.titleTop} >Location:</h3>
            <div id="rt_location"></div>
        </div>
    )
}

export default Location
