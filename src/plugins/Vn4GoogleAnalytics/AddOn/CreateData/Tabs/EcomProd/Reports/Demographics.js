import { CircularCustom } from 'components'
import React from 'react'
import { useSelector } from 'react-redux';
import dataMockup from './data';

function Demographics({ google }) {
    const theme = useSelector(state => state.theme);
    React.useEffect(() => {
        if (google) {

            google.charts.load('current', {
                'packages': ['corechart', 'geochart'], callback: function () {

                    var data = {
                        "cols": [
                            { "id": "Age", "label": "Age", "type": "string" },
                            { "id": "Female", "label": "Female", "type": "number" },
                            { "id": "Male", "label": "Male", "type": "number" }
                        ], "rows": dataMockup.demographics
                    };

                    new google.visualization.ColumnChart(document.getElementById('demographics_chart'))
                        .draw(new google.visualization.DataTable(data), {
                            title: '',
                            isStacked: true,
                            backgroundColor: 'transparent',
                            chartArea: { left: 0, right: 0, top: 0, bottom: 50 },
                            titleTextStyle: { color: theme.palette.text.secondary, fontSize: 16 },
                            vAxis: {
                                format: "##;##",
                            },
                            height: 400,
                            hAxis: {
                                title: "Age",
                                textStyle: { color: theme.palette.text.secondary },
                                titleTextStyle: { color: theme.palette.text.secondary },
                            }
                        }
                        );
                }
            });
        }
    }, [google]);

    if (!google || !dataMockup.demographics) {
        return <CircularCustom />
    }

    return (
        <div id="demographics_chart">
        </div>
    )
}

export default Demographics
