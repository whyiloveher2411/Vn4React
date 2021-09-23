import { Skeleton } from '@material-ui/lab';
import React from 'react'

function TrafficMedium({ classStyle, data, google }) {

    React.useEffect(() => {

        if (data && google.charts) {

            google.charts.load('current', {
                'packages': ['table', 'corechart', 'geochart'], callback: function () {


                    // Traffic Source
                    var dataChart = new google.visualization.DataTable();
                    dataChart.addColumn('string', 'Medium');
                    dataChart.addColumn('string', 'Source');
                    dataChart.addColumn('number', '');
                    dataChart.addColumn('number', 'Active Users', { 'width': '50px' });
                    dataChart.addRows(data.rt_source);
                    if (document.getElementById('rt_source')) {
                        if (!window.charts.rt_source) {
                            window.charts.rt_source = new google.visualization.Table(document.getElementById('rt_source'));
                        }
                        window.charts.rt_source.draw(dataChart, { showRowNumber: true, width: '100%' });
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
                    [0, 1, 2, 3, 4].map((i) => (
                        <div key={i} style={{ display: 'flex', margin: '0 -2px' }}>
                            <Skeleton style={{ height: 22, width: '10%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '25%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '35%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '10%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '20%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                        </div>
                    ))
                }
            </div>
        );
    }

    return (
        <div>
            <h3 className={classStyle.titleTop} >Traffic Medium:</h3>
            <div id="rt_source"></div>
        </div>
    )
}

export default TrafficMedium
