import { Skeleton } from '@material-ui/lab';
import React from 'react'

function Browser({ classStyle, data, google }) {

    React.useEffect(() => {

        if (data && google.charts) {

            google.charts.load('current', {
                'packages': ['table', 'corechart', 'geochart'], callback: function () {

                    let dataChart = new google.visualization.DataTable();
                    dataChart.addColumn('string', 'Browser');
                    dataChart.addColumn('number', '');
                    dataChart.addColumn('number', 'Active Users', { 'width': '50px' });
                    dataChart.addRows(data.rt_browser);
                    if (document.getElementById('rt_browser')) {

                        if (!window.charts.rt_browser) {
                            window.charts.rt_browser = new google.visualization.Table(document.getElementById('rt_browser'));
                        }

                        window.charts.rt_browser.draw(dataChart, { showRowNumber: true, width: '100%' });
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
                            <Skeleton style={{ height: 22, width: '15%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '35%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '15%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '35%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                        </div>
                    ))
                }
            </div>
        );
    }

    return (
        <div>
            <h3 className={classStyle.titleTop} >Browser:</h3>
            <div id="rt_browser"></div>
        </div>
    )
}

export default Browser
