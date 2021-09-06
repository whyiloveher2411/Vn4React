import { Card, CardHeader, Divider, Grid, IconButton } from '@material-ui/core';
import RefreshRoundedIcon from '@material-ui/icons/RefreshRounded';
import React from 'react';

function CreateDataAdvance(props) {
    if (props.data.action === 'EDIT') {
        return (
            <Grid item md={12} xs={12}>
                <Card>
                    <CardHeader
                        title="Analytics"
                        subheader="September 14, 2016"
                        action={
                            <IconButton aria-label="refesh">
                                <RefreshRoundedIcon />
                            </IconButton>
                        }
                    />
                    <Divider />
                </Card>
            </Grid>
        )
    }

    return null;
}

export default CreateDataAdvance
