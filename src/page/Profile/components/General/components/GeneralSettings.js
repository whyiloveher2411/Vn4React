import { Card, CardActions, CardContent, CardHeader, Divider, Grid } from '@material-ui/core';
import { Button, FieldForm } from 'components';
import PropTypes from 'prop-types';
import React, { useState } from 'react';

const GeneralSettings = (props) => {
    const { profile, className, onReview, handleSubmit, ...rest } = props

    let meta = {};

    try {
        if (typeof profile.meta === 'object') {
            meta = profile.meta;
        } else {
            meta = JSON.parse(profile.meta);
        }
    } catch (error) {
        meta = {};
    }

    if (!meta) meta = {};

    const [values, setValues] = useState({
        first_name: profile.first_name,
        last_name: profile.last_name,
        email: profile.email,
        number_phone: profile.number_phone ?? (meta.number_phone ?? ''),
    })

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
                            post={values}
                            name={'first_name'}
                            onReview={v => onReview(v, 'first_name')}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'Last Name',
                            }}
                            post={values}
                            name={'last_name'}
                            onReview={v => onReview(v, 'last_name')}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'Email',
                            }}
                            disabled
                            post={values}
                            name={'email'}
                            onReview={v => onReview(v, 'email')}
                        />
                    </Grid>
                    <Grid item md={6} xs={12}>
                        <FieldForm
                            compoment={'text'}
                            config={{
                                title: 'Phone',
                            }}
                            post={values}
                            name={'number_phone'}
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

GeneralSettings.propTypes = {
    className: PropTypes.string,
    profile: PropTypes.object.isRequired,
}

export default GeneralSettings
