import React from 'react'
import FieldForm from 'components/FieldForm';
import { Divider, Grid, InputAdornment, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';

function General(props) {

    const [profit, setProfit] = React.useState(false);

    const calculateProfit = (price, cost) => {

        console.log(price, cost);
        if (price && cost) {
            setProfit({
                money: price - cost,
                margin: Number(((parseFloat(price) - parseFloat(cost)) / parseFloat(price) * 100).toFixed(1))
            });
        } else {
            setProfit(false);
        }
    }

    React.useEffect(() => {
        if (profit === false && props.postDetail) {
            setProfit({
                money: props.postDetail.profit,
                margin: props.postDetail.profit_margin
            });
        }
    }, [props.postDetail]);

    if (props.post) {

        return (
            <Grid
                container
                spacing={3}>

                <Grid item md={6} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Price',
                            note: ' ',
                            maxLength: 70
                        }}
                        startAdornment={<InputAdornment position="start">$</InputAdornment>}
                        post={props.post}
                        name='general_price'
                        onReview={(value) => {
                            props.onReview(value, 'general_price');
                            calculateProfit(value, props.post.general_cost);
                        }}
                    />
                </Grid>
                <Grid item md={6} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Compare at Price',
                            note: ' ',
                            maxLength: 70
                        }}
                        startAdornment={<InputAdornment position="start">$</InputAdornment>}
                        post={props.post}
                        name='general_compare_price'
                        onReview={(value) => props.onReview(value, 'general_compare_price')}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    <Divider />
                </Grid>
                <Grid item md={6} xs={12}>
                    <FieldForm
                        compoment='number'
                        config={{
                            title: 'Cost per item',
                            note: 'Customers won’t see this',
                            maxLength: 70
                        }}
                        startAdornment={<InputAdornment position="start">$</InputAdornment>}
                        post={props.post}
                        name='general_cost'
                        onReview={(value) => {
                            props.onReview(value, 'general_cost');
                            calculateProfit(props.post.general_price, value);
                        }}
                    />
                </Grid>
                <Grid item md={6} xs={12}>
                    <Grid
                        container
                        spacing={2}>
                        <Grid item md={6} xs={12}>
                            <Typography variant="body2">Margin</Typography>
                            <Typography variant="body1">
                                {profit !== false ?
                                    new Intl.NumberFormat().format(profit.margin) + '%'
                                    :
                                    '-'
                                }
                            </Typography>
                        </Grid>
                        <Grid item md={6} xs={12}>
                            <Typography variant="body2">Profit</Typography>
                            <Typography variant="body1">
                                {profit !== false ?
                                    '$' + new Intl.NumberFormat().format(profit.money)
                                    :
                                    '-'
                                }
                            </Typography>
                        </Grid>
                    </Grid>
                </Grid>
                {/* <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'dateTime'}
                        config={{
                            title: 'Date of sale'
                        }}
                        post={props.post}
                        name={'general_date_of_sale'}
                        onReview={(value) => {
                            props.onReview(value, 'general_date_of_sale');
                        }}
                    />
                </Grid> */}
                {/* <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'date_range'}
                        config={{
                            title: 'Special Price From',
                            names: ['general_special_price_from', 'general_special_price_to'],
                        }}
                        post={props.post}
                        name={'general_special_price'}
                        onReview={props.onReview}
                    />
                </Grid> */}

                <Grid item md={12} xs={12}>
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: 'Charge tax on this product',
                            defaultValue: true,
                        }}
                        post={props.post}
                        name={'tax_class'}
                        onReview={(value) => {
                            props.onReview(value, 'tax_class');
                        }}
                    />
                </Grid>
            </Grid>
        )
    }

    return <Grid
        container
        spacing={3}>
        <Grid item md={6} xs={12}>
            <Skeleton variant="rect" width={'100%'} height={52} />
        </Grid>
        <Grid item md={6} xs={12}>
            <Skeleton variant="rect" width={'100%'} height={52} />
        </Grid>
        <Grid item md={12} xs={12}>
            <Skeleton variant="rect" width={'100%'} height={52} />
        </Grid>
        <Grid item md={12} xs={12}>
            <Skeleton variant="rect" width={'100%'} height={52} />
        </Grid>
        <Grid item md={12} xs={12}>
            <Skeleton variant="rect" width={'100%'} height={52} />
        </Grid>
    </Grid>
}

export default General