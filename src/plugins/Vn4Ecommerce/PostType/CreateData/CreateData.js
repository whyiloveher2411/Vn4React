import { Card, CardContent, CardHeader, Checkbox, colors, FormControlLabel, FormGroup, Grid, makeStyles, Tooltip, Typography } from '@material-ui/core';
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
import { __p } from 'utils/i18n';
import { PLUGIN_NAME } from '../../helpers/plugin';

const useStyles = makeStyles(() => ({
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
    // downloadable: 'downloadable',
    // virtual: 'virtual',

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
                        style={{ whiteSpace: 'nowrap' }}
                        title={
                            <div className={classes.cardTitle}>
                                <Typography variant="h5" >
                                    {__p('Product Data', PLUGIN_NAME)}
                                </Typography>
                                <div style={{ maxWidth: 260, width: '100%', marginLeft: 16 }}>
                                    <FieldForm
                                        compoment='select'
                                        config={{
                                            title: __p('Product type', PLUGIN_NAME),
                                            list_option: {
                                                simple: { title: __p('Simple Product', PLUGIN_NAME) },
                                                grouped: { title: __p('Grouped product', PLUGIN_NAME) },
                                                external: { title: __p('External/Affiliate product', PLUGIN_NAME) },
                                                variable: { title: __p('Variable product', PLUGIN_NAME) },
                                                // virtual: { title: __p('Virtual product', PLUGIN_NAME) },
                                                // downloadable: { title: __p('Downloadable product', PLUGIN_NAME) },
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
                                <FormGroup style={{ opacity: post.product_type === ecomName.simple ? 1 : 0 }}>
                                    <FormControlLabel
                                        style={{ marginRight: 24 }}
                                        control={<Checkbox
                                            onClick={() => {
                                                if (post.virtual_product) {
                                                    props.onReview(0, 'virtual_product');
                                                } else {
                                                    props.onReview(1, 'virtual_product');
                                                }
                                            }} checked={Boolean(post.virtual_product)} color="primary" />}
                                        label={__p('Virtual product', PLUGIN_NAME)}
                                    />
                                    <FormControlLabel
                                        control={<Checkbox
                                            onChange={() => {
                                                if (post.downloadable_product) {
                                                    props.onReview(0, 'downloadable_product');
                                                } else {
                                                    props.onReview(1, 'downloadable_product');
                                                }
                                            }} checked={Boolean(post.downloadable_product)} color="primary" />}
                                        label={__p('Downloadable product', PLUGIN_NAME)}
                                    />
                                </FormGroup>
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
                                                title: <Tooltip title={__p('Price', PLUGIN_NAME)}><AttachMoneyRoundedIcon /></Tooltip>,
                                                content: () => <General PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 1,
                                                // hidden: post.product_type === ecomName.variable,
                                            },
                                            overview: {
                                                title: <Tooltip title={__p('Overview', PLUGIN_NAME)}><InfoOutlinedIcon /></Tooltip>,
                                                content: () => <Overview PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 2,
                                            },
                                            properties: {
                                                title: <Tooltip title={__p('Properties', PLUGIN_NAME) + (post.product_type === 'variable' ? (' & ' + __p('Variations', PLUGIN_NAME)) : '')}><AppsRoundedIcon /></Tooltip>,
                                                content: () => <Properties PLUGIN_NAME={PLUGIN_NAME} updatePost={props.data.updatePost} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 3,
                                            },
                                            downloadable: {
                                                title: <Tooltip title={__p('Downloadable', PLUGIN_NAME)}><CloudDownloadOutlinedIcon /></Tooltip>,
                                                content: () => <Downloadable PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                hidden: !Boolean(post.downloadable_product) || post.product_type !== ecomName.simple,
                                                priority: 4,
                                            },
                                            warehouse: {
                                                title: <Tooltip title={__p('Warehouse', PLUGIN_NAME)}><HomeWorkOutlinedIcon /></Tooltip>,
                                                content: () => <Warehouse PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 5,
                                            },
                                            shipments: {
                                                title: <Tooltip title={__p('Shipments', PLUGIN_NAME)}><LocalShippingOutlinedIcon /></Tooltip>,
                                                content: () => <Shipments PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                hidden: (Boolean(post.virtual_product) && post.product_type === ecomName.simple) || ['', ecomName.simple, ecomName.variable].indexOf(post.product_type ?? '') === -1,
                                                priority: 6,
                                            },
                                            connectedproducts: {
                                                title: <Tooltip title={__p('Connected products', PLUGIN_NAME)}><ShoppingCartOutlinedIcon /></Tooltip>,
                                                content: () => <Connectedproducts PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 7,
                                            },
                                            specifications: {
                                                title: <Tooltip title={__p('Specifications', PLUGIN_NAME)}><BuildOutlinedIcon /></Tooltip>,
                                                content: () => <Specifications PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 8,
                                            },
                                            question_and_answer: {
                                                title: <Tooltip title={__p('Question and Answer', PLUGIN_NAME)}><HelpOutlineOutlinedIcon /></Tooltip>,
                                                content: () => <QuestionAndAnswer PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
                                                priority: 9,
                                            },
                                            advanced: {
                                                title: <Tooltip title={__p('Advanced', PLUGIN_NAME)}><SettingsOutlinedIcon /></Tooltip>,
                                                content: () => <Advanced PLUGIN_NAME={PLUGIN_NAME} onReview={onReview} postDetail={post} post={post.ecom_prod_detail} />,
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
            </Grid >
        )
    }

    return null;
}

const exp = {
    priority: 0,
    content: CreateData
};

export default exp

