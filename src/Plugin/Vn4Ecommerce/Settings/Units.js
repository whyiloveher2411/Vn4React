import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box, Grid } from '@material-ui/core';
import { DialogCustom, FieldForm, LoadingButton } from 'components';

function Units({ loading, ajaxPluginHandle }) {

    const [post, setPost] = React.useState({});

    const handleSubmit = () => {
        ajaxPluginHandle({
            url: 'units/settings',
            data: {
                action: 'LoadingCurrencies',
                data: post
            },
            success: (result) => {

            }
        });
    };

    React.useEffect(() => {



    }, []);

    return (
        <SettingEdit1
            title="Units"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Units</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                    onClick={handleSubmit}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Unit of Measure Class. Units of Measure. Base Unit of Measure. Quantity. dozen. box. each. each. Weight. pound. kilogram. gram. gram. Time. hour. minute"
        >
            <Grid container spacing={3}>
                <Grid item xs={12}>
                    <FieldForm
                        compoment="repeater"
                        config={{
                            title: 'Quantity',
                            layout: 'block',
                            sub_fields: {
                                name: { title: 'Name' },
                                symbol: { title: 'Symbol', view: 'text' },
                                number_of_decimals: { title: 'Number of decimals', view: 'number' },
                                rate: { title: 'Rate', view: 'number', },
                            },
                        }}
                        post={post}
                        name="quantity"
                        onReview={(value) => {
                            setPost({ ...post, quantity: value });
                        }}
                    />
                </Grid>
                <Grid item xs={12}>
                    <FieldForm
                        compoment="repeater"
                        config={{
                            title: 'Weight',
                            layout: 'block',
                            sub_fields: {
                                name: { title: 'Name' },
                                symbol: { title: 'Symbol', view: 'text' },
                                number_of_decimals: { title: 'Number of decimals', view: 'number' },
                                rate: { title: 'Rate', view: 'number', },
                            },
                        }}
                        post={post}
                        name="weight"
                        onReview={(value) => {
                            setPost({ ...post, weight: value });
                        }}
                    />
                </Grid>
                <Grid item xs={12}>
                    <FieldForm
                        compoment="repeater"
                        config={{
                            title: 'Height',
                            layout: 'block',
                            sub_fields: {
                                name: { title: 'Name' },
                                symbol: { title: 'Symbol', view: 'text' },
                                number_of_decimals: { title: 'Number of decimals', view: 'number' },
                                rate: { title: 'Rate', view: 'number', },
                            },
                        }}
                        post={post}
                        name="height"
                        onReview={(value) => {
                            setPost({ ...post, height: value });
                        }}
                    />
                </Grid>
            </Grid>

        </SettingEdit1>
    )
}

export default Units
