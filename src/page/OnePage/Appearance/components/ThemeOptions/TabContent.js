import { Grid } from '@material-ui/core'
import React from 'react'
import FieldForm from 'components/FieldForm';

function TabContent({ data, onReview }) {

    const onChangeTab = (value, key) => {

        if (typeof key === 'object' && key !== null) {

            data.value = {
                ...data.post,
                ...key
            };

            // data.post[key] = value;
        } else {
            data.value[key] = value;
        }

        onReview({ ...data.value });
    };


    return (
        <React.Fragment>
            <Grid
                container
                spacing={4}>
                {
                    data.fields &&
                    Object.keys(data.fields).map(key => {

                        let view = 'text';
                        let config = {};

                        if (typeof data.fields[key] === 'object') {
                            config = data.fields[key];
                            view = data.fields[key].view ?? 'text';

                        } else {
                            view = data.fields[key];
                        }

                        if (!config.title) {
                            config.title = key.replace(/\b\w/g, l => l.toUpperCase());
                        }


                        return (
                            <Grid item md={12} xs={12} key={key} >
                                <FieldForm
                                    compoment={view}
                                    config={config}
                                    post={data.value}
                                    name={key}
                                    onReview={(value, key2 = key) => { onChangeTab(value, key2) }}
                                />
                            </Grid>
                        )
                    })
                }
            </Grid>
        </React.Fragment>
    )
}

export default TabContent
