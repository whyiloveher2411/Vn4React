import { Card, CardActions, CardContent, CardHeader, Grid, Typography } from '@material-ui/core'
import React from 'react'
import FieldForm from 'components/FieldForm';
import Divider from '@material-ui/core/Divider'
import Button from 'components/Button';
import { __ } from 'utils/i18n';

function BasicInformation({ user, setUser, handleSubmit, enableEmail = false }) {
    return (
        <Grid
            container
            spacing={3}>
            <Grid item lg={4} md={6} xl={3} xs={12}>
                <Card>
                    <CardContent style={{
                        display: 'flex',
                        alignItems: 'center',
                        flexDirection: 'column',
                        textAlgin: 'center',
                    }}>
                        <div>
                            <FieldForm
                                compoment={'image'}
                                config={{
                                    title: '',
                                }}
                                post={user}
                                name={'profile_picture'}
                                onReview={value => {
                                    setUser(prev => ({
                                        ...prev,
                                        profile_picture: value,
                                    }));
                                }}
                            />
                        </div>
                    </CardContent>
                </Card>
            </Grid>
            <Grid item lg={8} md={6} xl={9} xs={12}>
                <Card>
                    <CardHeader title={__('Basic Information')} />
                    <Divider />
                    <CardContent>
                        <Grid container spacing={3}>
                            <Grid item xs={12} md={6}>
                                <FieldForm
                                    compoment={'text'}
                                    config={{
                                        title: __('First Name'),
                                    }}
                                    post={user}
                                    name={'first_name'}
                                    onReview={value => {
                                        setUser(prev => ({
                                            ...prev,
                                            first_name: value,
                                        }));
                                    }}
                                />
                            </Grid>
                            <Grid item xs={12} md={6}>
                                <FieldForm
                                    compoment={'text'}
                                    config={{
                                        title: __('Last Name'),
                                    }}
                                    post={user}
                                    name={'last_name'}
                                    onReview={value => {
                                        setUser(prev => ({
                                            ...prev,
                                            last_name: value,
                                        }));
                                    }}
                                />
                            </Grid>
                            <Grid item xs={12} md={6}>
                                <FieldForm
                                    compoment={'text'}
                                    config={{
                                        title: __('Email'),
                                    }}
                                    disabled={!enableEmail}
                                    post={user}
                                    name={'email'}
                                    onReview={value => {
                                        setUser(prev => ({
                                            ...prev,
                                            email: value,
                                        }));
                                    }}
                                />
                            </Grid>
                            <Grid item xs={12} md={6}>
                                <FieldForm
                                    compoment={'text'}
                                    config={{
                                        title: __('Phone'),
                                    }}
                                    post={user.meta}
                                    name={'number_phone'}
                                    onReview={value => {
                                        setUser(prev => ({
                                            ...prev,
                                            meta: {
                                                ...prev.meta,
                                                number_phone: value,
                                            }
                                        }));
                                    }}
                                />
                            </Grid>
                        </Grid>
                    </CardContent>
                    <Divider />
                    <CardActions>
                        <Button
                            onClick={handleSubmit}
                            color="success"
                            variant="contained">
                            {__('Save Changes')}
                        </Button>
                    </CardActions>
                </Card>
            </Grid>
        </Grid>
    )
}

export default BasicInformation
