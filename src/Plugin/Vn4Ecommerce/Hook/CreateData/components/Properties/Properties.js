import { Divider, Grid, Typography, FormControlLabel, Checkbox, FormControl, FormLabel, FormGroup } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import { FieldForm, NotFound } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import Variations from './Variations';

function Properties({ post, postDetail, onReview, updatePost }) {

    const { ajax, Loading, open } = useAjax({
        loadingType: 'custom'
    });

    const [valuesAttributes, setValuesAttributes] = React.useState({});

    const [listValuesAttributes, setListValuesAttributes] = React.useState({});

    const getValuesAttribute = (value) => {
        if (value && value.length) {
            ajax({
                url: 'plugin/vn4-ecommerce/create-data/get-values-attribute',
                method: 'POST',
                data: {
                    ids: value
                },
                success: (result) => {
                    if (result.attributes) {
                        setListValuesAttributes({ ...result.attributes });
                    } else {
                        setListValuesAttributes({});
                    }
                }
            });
        } else {
            setListValuesAttributes({});
        }
    }

    const parstPropertiesAttributesValues = (value) => {

        let result = {};

        if (typeof value === 'object') return value;

        if (typeof value === 'string') {
            try {
                result = JSON.parse(value);
            } catch (error) {
                result = {};
            }
        }

        let temp = {};

        result.forEach(item => {
            temp[item.id] = item;
        });

        result = Object.keys(temp).map(key => temp[key]);

        return result;
    };


    const loadAttributeValue = () => {
        post.attributesValues = [];

        post.properties_attributes_values.forEach(item => {

            if (item.ecom_prod_attr) {

                if (!post.attributesValues['attributes_' + item.ecom_prod_attr]) post.attributesValues['attributes_' + item.ecom_prod_attr] = [];

                post.attributesValues['attributes_' + item.ecom_prod_attr].push(item);

                post.attributesValues['attributes_' + item.ecom_prod_attr].sort((a, b) => a.id - b.id);
            }

        });

        setValuesAttributes({ ...post.attributesValues });
    }

    React.useEffect(() => {
        if (post) {
            getValuesAttribute(post.properties_attributes?.map(item => item.id));

            if (typeof post.properties_attributes_values === 'string') {

                try {
                    post.properties_attributes_values = JSON.parse(post.properties_attributes_values);
                } catch (error) {
                    post.properties_attributes_values = [];
                }

            }

            loadAttributeValue();
        }
    }, []);

    // React.useEffect(() => {
    //     alert(1);
    // }, []);

    const onChangeAttributesValues = (value, attribute, checked) => {

        if (checked) {

            if (!post.attributesValues) post.attributesValues = {};

            if (!post.attributesValues['attributes_' + attribute.id]) post.attributesValues['attributes_' + attribute.id] = [];

            post.attributesValues['attributes_' + attribute.id].push(value);

            post.attributesValues['attributes_' + attribute.id].sort((a, b) => a.id - b.id);

            post.properties_attributes_values = parstPropertiesAttributesValues(post.properties_attributes_values);
            post.properties_attributes_values.push(value);

        } else {
            post.attributesValues['attributes_' + attribute.id] = post.attributesValues['attributes_' + attribute.id].filter(item => item.id != value.id);
            post.properties_attributes_values = parstPropertiesAttributesValues(post.properties_attributes_values);
            post.properties_attributes_values = post.properties_attributes_values.filter(item => item.id !== value.id);
        }

        onReview(null, {
            properties_attributes_values: post.properties_attributes_values,
            attributesValues: post.attributesValues
        });
        setValuesAttributes({ ...post.attributesValues })

    }

    if (post) {
        return (
            <Grid
                container
                spacing={3}>
                <Grid item md={12} xs={12}>
                    <Typography variant="h4">Properties</Typography>
                    <br />
                    <FieldForm
                        compoment='relationship_manytomany'
                        config={{
                            title: 'Custom product attribute',
                            object: 'ecom_prod_attr',
                            placeholder: ''
                        }}
                        post={post}
                        name='properties_attributes'
                        onReview={(value) => {
                            getValuesAttribute(value.map(item => item.id));
                        }}
                    />
                </Grid>
                <Grid item md={12} xs={12}>
                    {
                        open ?
                            <div style={{ minHeight: 200, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                {Loading}
                            </div>
                            :
                            <Grid
                                container
                                spacing={2}
                            >

                                <Grid item md={12} xs={12}>
                                    <Divider />
                                </Grid>

                                {
                                    (() => {

                                        if (typeof post.properties_attributes === 'string') {

                                            try {
                                                post.properties_attributes = JSON.parse(post.properties_attributes);
                                            } catch (error) {
                                                post.properties_attributes = [];
                                            }
                                        }

                                        if (Array.isArray(post.properties_attributes)) {

                                            return post.properties_attributes.map(attribute => {

                                                if (!listValuesAttributes['id_' + attribute.id]) return null;

                                                return (
                                                    <Grid key={attribute.id} item md={12} xs={12}>
                                                        <FormControl >
                                                            <Typography>{attribute.title}</Typography>
                                                            <FormGroup row>

                                                                {
                                                                    listValuesAttributes['id_' + attribute.id].values?.map(value => (<FormControlLabel
                                                                        key={value.id}
                                                                        control={<Checkbox
                                                                            checked={Boolean(valuesAttributes
                                                                                && valuesAttributes['attributes_' + attribute.id]
                                                                                && valuesAttributes['attributes_' + attribute.id].filter(item => item.id === value.id).length > 0)}
                                                                            value={value.id}
                                                                            onChange={(e) => { onChangeAttributesValues(value, attribute, e.target.checked) }}
                                                                            color="primary"
                                                                        />}
                                                                        label={value.title}
                                                                    />
                                                                    ))
                                                                }
                                                            </FormGroup>
                                                        </FormControl>
                                                    </Grid>
                                                )
                                            })
                                        }

                                        return null;
                                    })()

                                }
                                {
                                    postDetail.product_type === 'variable' &&
                                    (
                                        Object.keys(valuesAttributes).length > 0 ?
                                            <>
                                                <Grid item md={12} xs={12}>
                                                    <Divider />
                                                </Grid>
                                                < Grid item md={12} xs={12}>
                                                    <Variations onReview={(value) => {
                                                        onReview(value, 'variations')
                                                    }} post={post} postDetail={postDetail} valuesAttributes={valuesAttributes} attributes={post.properties_attributes} />
                                                </Grid>
                                            </>
                                            :
                                            <>
                                                <Grid item md={12} xs={12}>
                                                    <Divider />
                                                </Grid>
                                                < Grid item md={12} xs={12}>
                                                    <NotFound>
                                                        Nothing To Display. <br />
                                                        <span style={{ color: '#ababab', fontSize: '16px' }}>No matching variants found for properties</span>
                                                    </NotFound>
                                                </Grid>
                                            </>
                                    )
                                }
                            </Grid>
                    }

                </Grid>
            </Grid >
        )
    }

    return (
        <Grid
            container
            spacing={3}>
            <Grid item md={12} xs={12}>
                <Skeleton variant="text" width={'100%'} height={32} />
                <br />
                <Skeleton variant="rect" width={'100%'} height={52} />
            </Grid>
            <Grid item md={12} xs={12}>
                <Grid
                    container
                    spacing={2}
                >
                    <Grid item md={12} xs={12}>
                        <Divider />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                    </Grid>
                    <Grid item md={12} xs={12}>
                        <Divider />
                    </Grid>
                    < Grid item md={12} xs={12}>
                        <Skeleton variant="rect" width={'100%'} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                        <Skeleton variant="rect" width={'100%'} style={{ margin: '4px 0' }} height={32} />
                    </Grid>
                </Grid>
            </Grid>
        </Grid >
    )
}

export default Properties
