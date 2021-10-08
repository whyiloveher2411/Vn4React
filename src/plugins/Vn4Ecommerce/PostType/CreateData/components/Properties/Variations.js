import { Box, Button, Grid, IconButton, Typography } from '@material-ui/core';
import InputAdornment from '@material-ui/core/InputAdornment';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import TextField from '@material-ui/core/TextField';
import CreateOutlinedIcon from '@material-ui/icons/CreateOutlined';
import DeleteOutlineRoundedIcon from '@material-ui/icons/DeleteOutlineRounded';
import RestoreFromTrashOutlinedIcon from '@material-ui/icons/RestoreFromTrashOutlined';
import { DrawerCustom, FieldForm, NotFound } from 'components';
import React from 'react';
import { copyArray } from 'utils/helper';
import UpdateIcon from '@material-ui/icons/Update';

function Variations({ valuesAttributes, attributes, postDetail, post, onReview }) {

    const createVariationsFromTwoArray = (attributesValues, length) => {

        let resultTemp = new Array();

        let step = 1;

        attributesValues.forEach((values) => {

            step = step * values.length;

            let limitChange = length / step;

            let index = 0;

            while (index < length) {


                values.forEach(value => {

                    let index2 = limitChange;

                    while (index2 > 0) {

                        if (!resultTemp[index]) resultTemp[index] = { attributes: [], delete: 0 };

                        resultTemp[index].attributes.push(value);
                        index2--;
                        index++;

                    }

                });
            }

        });

        let result = {};

        if (resultTemp.length) {
            for (let i = 0; i < length; i++) {

                let key = [];
                let variantTitle = [];
                let variantLabel = [];
                let skuGenerate = [];

                resultTemp[i].attributes.forEach(value => {

                    key.push(value.id);
                    variantLabel.push(value.title);

                    if (attributesKey['id_' + value.ecom_prod_attr]) {
                        variantTitle.push(attributesKey['id_' + value.ecom_prod_attr].title + ' ' + value.title);
                        skuGenerate.push(attributesKey['id_' + value.ecom_prod_attr].sku_code + value.id);
                    } else {
                        console.log(attributesKey, 'faillllllllllllllllllll');
                    }

                });

                result['KEY_' + key.join('_')] = {
                    ...resultTemp[i],
                    key: key.join('_'),
                    label: variantLabel.join(' / '),
                    title: postDetail.title + ' - ' + variantTitle.join(' - '),
                    sku: skuGenerate.join('-'),
                    price: postDetail.ecom_prod_detail.general_price,
                    compare_price: postDetail.ecom_prod_detail.general_compare_price,
                };
            }
        }

        return result;
    }



    const getVariations = () => {

        if (attributes && attributes.length) {

            let attributesValuesInvalid = [];

            let length = 1;

            attributes.forEach(attr => {

                attributesKey['id_' + attr.id] = attr;

                if (valuesAttributes['attributes_' + attr.id] && valuesAttributes['attributes_' + attr.id].length) {

                    attributesValuesInvalid[attributesValuesInvalid.length] = [...valuesAttributes['attributes_' + attr.id]];

                    length = length * valuesAttributes['attributes_' + attr.id].length;
                }
            });

            return createVariationsFromTwoArray(attributesValuesInvalid, length);

        }

        return {};
    };

    const filterOldValueNewValue = (valueOld, valueNew) => {

        if ( !valueOld || Object.keys(valueOld).length < 1) return valueNew;

        Object.keys(valueNew).forEach(key => {
            if (valueOld[key]) {
                valueNew[key] = valueOld[key];
            }
        });

        return valueNew;
    };

    const setVariations = () => {

        if (typeof post.variations !== 'object') {

            try {
                post.variations = JSON.parse(post.variations);
            } catch (error) {
                post.variations = {}
            }

        }

        let variations = filterOldValueNewValue(post.variations, getVariations());

        post.variations = variations;

        onReview({ ...variations });
    };

    // const [variations, setVariations] = React.useState([]);
    const [attributesKey, setAttributesKey] = React.useState({});

    const [editVariationCurrent, setEditVariationCurrent] = React.useState({ open: false, variation: {} });

    const [render, setRender] = React.useState(0);

    React.useEffect(() => {

    }, []);

    React.useEffect(() => {
        // console.log(1);
        // setVariations();
    }, [attributes]);

    React.useEffect(() => {
        setVariations();
    }, [valuesAttributes]);

    const handleDeleteVariation = (variation) => {
        variation.delete = !variation.delete;
        setRender(render + 1);
    };

    const handleEditVariation = (variation) => {
        setEditVariationCurrent({ open: true, variation: copyArray(variation) });
    }

    const handleDeleteVariantionCurrent = () => {
        post.variations['KEY_' + editVariationCurrent.variation.key].delete = true;
        setEditVariationCurrent({ ...editVariationCurrent, open: false });
    }

    const handleSaveVariantionCurrent = () => {
        post.variations['KEY_' + editVariationCurrent.variation.key] = copyArray(editVariationCurrent.variation);
        setEditVariationCurrent({ ...editVariationCurrent, open: false });
    }

    if (!post.variations || Object.keys(post.variations).length < 1 || Object.keys(attributesKey).length < 1) {
        return (
            <NotFound subTitle="No matching variants found for properties" />
        );
    }


    return (
        <>
            <Typography variant="h4">Variations ({Object.keys(post.variations).length})</Typography>
            <br />
            <Table aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell padding="none"></TableCell>
                        <TableCell style={{ textAlign: 'center' }}>Variant <Typography variant="body2" style={{ whiteSpace: 'nowrap' }}>Color / Size</Typography></TableCell>
                        <TableCell style={{ textAlign: 'center' }}>Name</TableCell>
                        <TableCell style={{ textAlign: 'center' }}>SKU</TableCell>
                        <TableCell style={{ textAlign: 'center' }}> <Box display="flex" alignItems="center" justifyContent="space-between">Price <IconButton style={{ opacity: 0 }} size="small"><UpdateIcon /></IconButton></Box> </TableCell>
                        <TableCell style={{ textAlign: 'center' }}>Quantity</TableCell>
                        <TableCell style={{ textAlign: 'center' }}>Weight</TableCell>
                        <TableCell></TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {Object.keys(post.variations).map((key, index) => (<TableRow key={key}>
                        <TableCell padding="none" align="center"> <span style={{ color: '#dadada', fontWeight: 'bold' }}>{index + 1}.</span></TableCell>
                        <TableCell component="th" scope="row" style={{ whiteSpace: 'nowrap' }}>
                            {post.variations[key].label}
                        </TableCell>

                        {
                            !post.variations[key].delete ?
                                <>
                                    <TableCell >
                                        <FieldForm
                                            compoment="text"
                                            config={{
                                                title: false,
                                                size: 'small',
                                            }}
                                            labelWidth={0}
                                            post={post.variations[key]}
                                            name="title"
                                            onReview={() => {
                                            }}
                                        />
                                    </TableCell>
                                    <TableCell>
                                        <FieldForm
                                            compoment="text"
                                            config={{
                                                title: false,
                                                size: 'small',
                                            }}
                                            labelWidth={0}
                                            post={post.variations[key]}
                                            name="sku"
                                            onReview={() => {
                                            }}
                                        />
                                    </TableCell>
                                    <TableCell>
                                        <FieldForm
                                            compoment="number"
                                            config={{
                                                title: false,
                                                size: 'small',
                                            }}
                                            startAdornment={<InputAdornment position="start">$</InputAdornment>}
                                            labelWidth={0}
                                            post={post.variations[key]}
                                            name="price"
                                            onReview={() => {
                                            }}
                                        />
                                    </TableCell>
                                    <TableCell>
                                        <FieldForm
                                            compoment="number"
                                            config={{
                                                title: false,
                                                size: 'small',
                                            }}
                                            labelWidth={0}
                                            post={post.variations[key]}
                                            name="quantity"
                                            onReview={(value) => {
                                                post.variations[key].quantity = value;
                                                console.log(post.variations);
                                            }}
                                        />
                                    </TableCell>
                                    <TableCell>
                                        <FieldForm
                                            compoment="number"
                                            config={{
                                                title: false,
                                                size: 'small',
                                            }}
                                            endAdornment={<InputAdornment position="start">kg</InputAdornment>}
                                            labelWidth={0}
                                            post={post.variations[key]}
                                            name="weight"
                                            onReview={() => { }}
                                        />
                                    </TableCell>
                                    <TableCell>
                                        <Box display="flex" alignItems="center">
                                            <IconButton onClick={() => handleEditVariation(post.variations[key])} color="default" aria-label="delete" component="span">
                                                <CreateOutlinedIcon />
                                            </IconButton>
                                            <IconButton onClick={() => handleDeleteVariation(post.variations[key])} color="default" aria-label="delete" component="span">
                                                <DeleteOutlineRoundedIcon />
                                            </IconButton>
                                        </Box>
                                    </TableCell>
                                </>
                                :
                                <>
                                    <TableCell colSpan={5} align="right">
                                        <Typography variant="body1">This variant will not be created</Typography>
                                    </TableCell>
                                    <TableCell colSpan={6} align="right">
                                        <IconButton onClick={() => handleDeleteVariation(post.variations[key])} color="default" aria-label="delete" component="span">
                                            <RestoreFromTrashOutlinedIcon />
                                        </IconButton>
                                    </TableCell>
                                </>
                        }
                    </TableRow>
                    ))}
                </TableBody>
            </Table>
            <DrawerCustom
                open={editVariationCurrent.open}
                onClose={() => { setEditVariationCurrent({ ...editVariationCurrent, open: false }) }}
                title={'Variation: ' + editVariationCurrent.variation.label}
                action={<>
                    <Box width={1} display="flex" justifyContent="space-between">
                        <Button onClick={handleSaveVariantionCurrent} color="primary" variant="contained" >Save Changes</Button>
                        <Button onClick={handleDeleteVariantionCurrent} color="secondary" variant="contained" >Delete</Button>
                    </Box>
                </>}
                width={800}
            >
                <Grid container spacing={3}>
                    <Grid item md={12}>
                        <FieldForm
                            compoment="text"
                            config={{
                                title: 'Title',
                            }}
                            name="title"
                            post={editVariationCurrent.variation}
                            onReview={(value) => { }}
                        />
                    </Grid>
                    <Grid item md={12}>
                        <FieldForm
                            compoment="text"
                            config={{
                                title: 'SKU',
                            }}
                            name="sku"
                            post={editVariationCurrent.variation}
                            onReview={(value) => { }}
                        />
                    </Grid>

                    <Grid item md={12}>

                        <Grid container spacing={2}>
                            <Grid item md={6}>
                                <FieldForm
                                    compoment="number"
                                    config={{
                                        title: 'Price',
                                    }}
                                    name="price"
                                    post={editVariationCurrent.variation}
                                    onReview={(value) => { }}
                                />
                            </Grid>
                            <Grid item md={6}>
                                <FieldForm
                                    compoment="number"
                                    config={{
                                        title: 'Compare at Price',
                                    }}
                                    name="compare_price"
                                    post={editVariationCurrent.variation}
                                    onReview={(value) => { }}
                                />
                            </Grid>
                        </Grid>


                    </Grid>


                    <Grid item md={12}>
                        <FieldForm
                            compoment="text"
                            config={{
                                title: 'Quantity',
                            }}
                            name="quantity"
                            post={editVariationCurrent.variation}
                            onReview={(value) => { }}
                        />
                    </Grid>
                    <Grid item md={12}>
                        <FieldForm
                            compoment="image"
                            config={{
                                title: 'Images',
                                multiple: true,
                            }}
                            name="images"
                            post={editVariationCurrent.variation}
                            onReview={(value) => { }}
                        />
                    </Grid>

                </Grid>
            </DrawerCustom>
        </>
    )
}

export default Variations
