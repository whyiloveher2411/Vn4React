import { Grid } from '@material-ui/core';
import { FieldForm } from 'components';
import React from 'react'

function Address(props) {
    const { data, fields, onReview } = props;

    return (
        <Grid container spacing={3}>
            {
                fields.map(key => (
                    <Grid key={key} item xs={12} md={6}>
                        <FieldForm
                            compoment={data.config.fields[key].view}
                            config={data.config.fields[key]}
                            post={data.post}
                            name={key}
                            onReview={(value, key2 = key) => onReview(value, key2)}
                        />
                    </Grid>
                ))
            }
        </Grid>
    )
}

export default Address
