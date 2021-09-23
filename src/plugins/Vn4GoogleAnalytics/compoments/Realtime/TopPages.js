import { Skeleton } from '@material-ui/lab';
import React from 'react'

function TopPages({ classStyle, data, google }) {

    React.useEffect(() => {

        if (data && google.charts) {

            google.charts.load('current', {
                'packages': ['table', 'corechart', 'geochart'], callback: function () {

                    let dataChart = new google.visualization.DataTable();
                    dataChart.addColumn('string', 'Active Page');
                    dataChart.addColumn('number', '');
                    dataChart.addColumn('number', 'Active Users', { 'width': '50px' });
                    dataChart.addRows(data.rt_pagePath);

                    if (document.getElementById('rt_pagePath')) {
                        if (!window.charts.rt_pagePath) {
                            window.charts.rt_pagePath = new google.visualization.Table(document.getElementById('rt_pagePath'));
                        }
                        window.charts.rt_pagePath.draw(dataChart, { showRowNumber: true, allowHtml: true, width: '100%' });
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
                    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map((i) => (
                        <div key={i} style={{ display: 'flex', margin: '0 -2px' }}>
                            <Skeleton style={{ height: 22, width: '5%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                            <Skeleton style={{ height: 22, width: '65%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
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
            <h3 className={classStyle.titleTop} >Top Active Pages:</h3>
            <div id="rt_pagePath" style={{ marginBottom: 5 }}></div>
        </div>
    )
}

export default TopPages
