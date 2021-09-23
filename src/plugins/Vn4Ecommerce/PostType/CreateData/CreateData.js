import { Card, CardContent, CardHeader, colors, Grid, makeStyles, Tooltip, Typography } from '@material-ui/core';
import AppsRoundedIcon from '@material-ui/icons/AppsRounded';
import BuildOutlinedIcon from '@material-ui/icons/BuildOutlined';
import CloudDownloadOutlinedIcon from '@material-ui/icons/CloudDownloadOutlined';
import HelpOutlineOutlinedIcon from '@material-ui/icons/HelpOutlineOutlined';
import HomeWorkOutlinedIcon from '@material-ui/icons/HomeWorkOutlined';
import InfoOutlinedIcon from '@material-ui/icons/InfoOutlined';
import LocalShippingOutlinedIcon from '@material-ui/icons/LocalShippingOutlined';
import AttachMoneyRoundedIcon from '@material-ui/icons/AttachMoneyRounded';
import SettingsOutlinedIcon from '@material-ui/icons/SettingsOutlined';
import ShoppingCartOutlinedIcon from '@material-ui/icons/ShoppingCartOutlined';
import { AddOn, Divider, FieldForm, TabsCustom } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { Advanced, Connectedproducts, Downloadable, General, Overview, Properties, QuestionAndAnswer, Shipments, Specifications, Warehouse } from './components';


const useStyles = makeStyles((theme) => ({
    cardTitle: {
        alignItems: 'center', display: 'flex',
        '& .MuiFormGroup-root': {
            display: 'flex',
            width: '100%',
            flexDirection: 'row',
            marginLeft: 32
        }
    }
}));

const ecomName = {
    simple: 'simple',
    grouped: 'grouped',
    external: 'external',
    variable: 'variable',
    downloadable: 'downloadable',
    virtual: 'virtual',

    prodType: 'ecom_prod',
}

function CreateData(props) {

    const { post } = props.data;

    const classes = useStyles();
    const [render, setRender] = React.useState(0);

    const useAjax1 = useAjax();

    const { callAddOn } = AddOn();

    const [tabCurrent, setTabCurrent] = React.useState({ index: 0 });

    React.useEffect(() => {

        if (props.postType === ecomName.prodType) {

            if (!props.data?.post?.ecom_prod_detail?._updatePost) {

                useAjax1.ajax({
                    url: 'plugin/vn4-ecommerce/create-data/get-product-detail',
                    data: {
                        ...post
                    },
                    success: function (result) {
                        if (result.post) {
                            result.post._updatePost = new Date();
                            props.onReview(result.post, 'ecom_prod_detail');
                        }
                    }
                });
            }

            try {
                if (post.meta) {
                    if (typeof post.meta === 'string') {
                        post.meta = JSON.parse(post.meta);
                    }
                }
            } catch (error) {

            }

            if (post.meta === null || typeof post.meta !== 'object') {
                post.meta = {};
            }

            setRender(render + 1);
        }

    }, [props.data.updatePost]);

    const onReview = (value, key) => {

        if (key === 'general_price') {

            props.onReview(null, {
                price: value,
                ecom_prod_detail: { ...props.data.post.ecom_prod_detail, general_price: value }
            });

        } else if (key === 'general_compare_price') {
            props.onReview(null, {
                compare_price: value,
                ecom_prod_detail: { ...props.data.post.ecom_prod_detail, general_compare_price: value }
            });
        } else if (key === 'general_cost') {
            props.onReview(null, {
                cost: value,
                ecom_prod_detail: { ...props.data.post.ecom_prod_detail, general_cost: value }
            });

        } else {

            if (typeof key === 'object' && key !== null) {
                props.data.post.ecom_prod_detail = {
                    ...props.data.post.ecom_prod_detail,
                    ...key
                };
            } else {
                props.data.post.ecom_prod_detail[key] = value;
            }

            props.onReview(props.data.post.ecom_prod_detail, 'ecom_prod_detail');
        }
    };

    if (props.postType === ecomName.prodType) {
        return (
            <Grid item md={12} xs={12}>
                <Card>
                    <CardHeader
                        title={
                            <div className={classes.cardTitle}>
                                <Typography variant="h5" >
                                    Product Data
                                </Typography>
                                <div style={{ maxWidth: 260, width: '100%', marginLeft: 16 }}>
                                    <FieldForm
                                        compoment='select'
                                        config={{
                                            title: 'Product type',
                                            list_option: {
                                                simple: { title: 'Simple Product' },
                                                grouped: { title: 'Grouped product' },
                                                external: { title: 'External/Affiliate product' },
                                                variable: { title: 'Variable product' },
                                                virtual: { title: 'Virtual product' },
                                                downloadable: { title: 'Downloadable product' },
                                            },
                                            size: "small",
                                            defaultValue: 'simple',
                                            inputProps: {
                                                disableClearable: true
                                            }
                                        }}
                                        post={post}
                                        name='product_type'
                                        onReview={(value) => {
                                            // setRender(prev => prev + 1);
                                            onReview(value, 'product_type');
                                        }}
                                    />
                                </div>
                            </div>}
                    />
                    <Divider />
                    <CardContent>
                        <TabsCustom
                            name="vn4ecom_createdata"
                            orientation='vertical'
                            tabIcon={true}
                            onChangeTab={(i) => { setTabCurrent({ index: i }); }}
                            tabIndex={tabCurrent.index}
                            tabs={
                                (() => {
                                    let tabs = callAddOn(
                                        'CreateData/Ecommerce',
                                        'Tabs',
                                        {
                                            general: {
                                                title: <Tooltip title="Price"><AttachMoneyRoundedIcon /></Tooltip>,
                                                content: () => <General onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 1,
                                                // hidden: post.product_type === ecomName.variable,
                                            },
                                            overview: {
                                                title: <Tooltip title="Overview"><InfoOutlinedIcon /></Tooltip>,
                                                content: () => <Overview onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 2,
                                            },
                                            properties: {
                                                title: <Tooltip title={"Properties" + (post.product_type === 'variable' ? ' & Variations' : '')}><AppsRoundedIcon /></Tooltip>,
                                                content: () => <Properties updatePost={props.data.updatePost} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 3,
                                            },
                                            downloadable: {
                                                title: <Tooltip title="Downloadable"><CloudDownloadOutlinedIcon /></Tooltip>,
                                                content: () => <Downloadable onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                hidden: post.product_type !== ecomName.downloadable,
                                                priority: 4,
                                            },
                                            warehouse: {
                                                title: <Tooltip title="Warehouse"><HomeWorkOutlinedIcon /></Tooltip>,
                                                content: () => <Warehouse onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 5,
                                            },
                                            shipments: {
                                                title: <Tooltip title="Shipments"><LocalShippingOutlinedIcon /></Tooltip>,
                                                content: () => <Shipments onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                hidden: ['', ecomName.simple, ecomName.variable].indexOf(post.product_type ?? '') === -1,
                                                priority: 6,
                                            },
                                            connectedproducts: {
                                                title: <Tooltip title="Connected products"><ShoppingCartOutlinedIcon /></Tooltip>,
                                                content: () => <Connectedproducts onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 7,
                                            },
                                            specifications: {
                                                title: <Tooltip title="Specifications"><BuildOutlinedIcon /></Tooltip>,
                                                content: () => <Specifications onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 8,
                                            },
                                            question_and_answer: {
                                                title: <Tooltip title="Question and Answer"><HelpOutlineOutlinedIcon /></Tooltip>,
                                                content: () => <QuestionAndAnswer onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 9,
                                            },
                                            advanced: {
                                                title: <Tooltip title="Advanced"><SettingsOutlinedIcon /></Tooltip>,
                                                content: () => <Advanced onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 10,
                                            },

                                        },
                                        {
                                            updatePost: props.data.updatePost,
                                            onReview: onReview,
                                            postDetail: post,
                                            post: post.ecom_prod_detail
                                        });

                                    return Object.keys(tabs).map(key => tabs[key]);
                                })()
                            }
                        />
                    </CardContent>
                </Card>
            </Grid>
        )
    }

    return null;
}

const exp = {
    priority: 0,
    content: CreateData
};

export default exp

