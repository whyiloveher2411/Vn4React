import { Card, CardActions, CardContent, CardHeader, Divider, Grid } from '@material-ui/core';
import { FieldForm, Button } from 'components';
import React from 'react';

const GeneralSettings = (props) => {
    const { profile, className, onReview, handleSubmit, action, ...rest } = props

    let meta = {};

    try {
        if (typeof profile.meta === 'object') {
            meta = profile.meta;
        } else {
            meta = JSON.parse(profile.meta);
        }
    } catch (error) {
    }

    if (!meta) {
        meta = {};
    }
    let valueInital = {
        first_name: profile.first_name,
        last_name: profile.last_name,
        email: profile.email,
        number_phone: profile.number_phone ?? (meta.number_phone ? meta.number_phone : ''),
    };


    return (
        <Card {...rest}>
            <CardHeader title="Profile" />
            <Divider />
            <CardContent>
                <Grid container spacing={4}>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'First Name',
                            }}
                            post={valueInital}
                            name={'first_name'}
                            autoComplete="___"
                            onReview={v => onReview(v, 'first_name')}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'Last Name',
                            }}
                            post={valueInital}
                            name={'last_name'}
                            autoComplete="___"
                            onReview={v => onReview(v, 'last_name')}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'Email',
                            }}
                            disabled={action !== 'ADD_NEW'}
                            post={valueInital}
                            name={'email'}
                            autoComplete="___"
                            onReview={v => onReview(v, 'email')}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'Phone',
                            }}
                            post={valueInital}
                            name={'number_phone'}
                            autoComplete="___"
                            onReview={v => onReview(v, 'number_phone')}
                        />
                    </Grid>
                </Grid>
            </CardContent>
            <Divider />
            <CardActions>
                <Button
                    type="submit"
                    onClick={handleSubmit}
                    color="success"
                    variant="contained">
                    Save Changes
                </Button>
            </CardActions>
        </Card>
    )
}

export default GeneralSettings
