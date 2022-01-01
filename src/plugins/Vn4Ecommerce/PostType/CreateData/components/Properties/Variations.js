import { ButtonGroup, Checkbox, makeStyles } from '@material-ui/core';
import Box from '@material-ui/core/Box';
import Button from '@material-ui/core/Button';
import IconButton from '@material-ui/core/IconButton';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Typography from '@material-ui/core/Typography';
import CloseIcon from '@material-ui/icons/Close';
import CreateOutlinedIcon from '@material-ui/icons/CreateOutlined';
import DeleteOutlineRoundedIcon from '@material-ui/icons/DeleteOutlineRounded';
import RestoreFromTrashOutlinedIcon from '@material-ui/icons/RestoreFromTrashOutlined';
import { AvatarCustom } from 'components';
import ActionBar from 'components/ActionBar';
import DrawerCustom from 'components/DrawerCustom';
import NotFound from 'components/NotFound';
import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';
import React from 'react';
import { useSelector } from 'react-redux';
import { __p } from 'utils/i18n';
import BulkEditor from './BulkEditor';
import VariationsForm from './VariationsForm';

const useStyles = makeStyles(theme => ({
    drawerContent: {
        backgroundColor: theme.palette.body.background,
    },
    variableImage: {
        width: 40,
        height: 40,
        border: '1px solid ' + theme.palette.dividerDark,
        borderRadius: 4,
        overflow: 'hidden',
        '& svg': {
            fill: theme.palette.text.secondary + ' !important',
            color: theme.palette.text.secondary + ' !important',
            backgroundColor: 'unset !important',
        }
    },
    variationItem: {
        cursor: 'pointer',
        '&:hover': {
            backgroundColor: theme.palette.divider,
        }
    },
    selectItem: {
        cursor: 'pointer',
        margin: 8,
        color: theme.palette.text.link,
    }
}));


function Variations({ listValuesAttributes, valuesAttributes, attributes, postDetail, post, onReview, PLUGIN_NAME }) {

    const theme = useSelector(s => s.theme);

    const classes = useStyles();

    const createVariationsFromTwoArray = (attributesValues, length) => {

        let resultTemp = [];

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
                    }
                });

                result['KEY_' + key.join('_')] = {
                    ...resultTemp[i],
                    key: key.join('_'),
                    label: variantLabel.join(' / '),
                    title: postDetail.title + ' - ' + variantTitle.join(' - '),
                    sku: skuGenerate.join('-'),
                    ...postDetail.ecom_prod_detail
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

        if (!valueOld || Object.keys(valueOld).length < 1) return valueNew;

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

    const [attributesKey, setAttributesKey] = React.useState({});

    const [editVariationCurrent, setEditVariationCurrent] = React.useState({ open: false, variation: {} });

    const openBulkEditor = React.useState(false);

    React.useEffect(() => {
        setVariations();
    }, [valuesAttributes]);

    const handleDeleteVariation = (key) => (e) => {
        e.stopPropagation();
        post.variations[key].delete = !post.variations[key].delete;
        onReview({ ...post.variations });
    };

    const handleEditVariation = (key) => () => {
        setEditVariationCurrent({ open: true, key: key });
    }

    const handleChangeVariations = (variations) => {
        onReview(variations);
        setEditVariationCurrent({ open: false, key: '' });
    }

    const [variationsSelected, setVariationsSelected] = React.useState({});

    const keysVariationsSelected = Object.keys(variationsSelected);

    const keyVariations = (typeof post.variations === 'object' && post.variations !== null) ? Object.keys(post.variations) : [];

    const handleClickSelectvariationsGroup = (keyAttr, valueSearch) => (e) => {
        if (keyAttr === 'all') {
            setVariationsSelected({ ...post.variations });
        } else if (keyAttr === 'none') {
            setVariationsSelected({});
        } else {

            let variationsResult = {};

            keyVariations.forEach((key) => {
                if (post.variations[key].attributes.filter(value => value.id === valueSearch.id).length > 0) {
                    variationsResult[key] = post.variations[key];
                }
            });

            setVariationsSelected(prev => ({
                ...prev,
                ...variationsResult
            }));
        }
    }

    if (!post.variations || keyVariations.length < 1 || Object.keys(attributesKey).length < 1) {
        return (
            <NotFound subTitle="No matching variants found for properties" />
        );
    }

    const handleClickCheckboxSelect = (e) => {
        e.stopPropagation();
        if (keysVariationsSelected.length === 0 || keysVariationsSelected.length < keyVariations.length) {
            setVariationsSelected({ ...post.variations });
        } else {
            setVariationsSelected({});
        }
    }

    const checkboxSelect = <Checkbox
        indeterminate={keysVariationsSelected.length > 0 && keysVariationsSelected.length < keyVariations.length}
        color={(keysVariationsSelected.length > 0 && keysVariationsSelected.length < keyVariations.length) ? 'default' : 'primary'}
        checked={keysVariationsSelected.length === keyVariations.length}
        onClick={handleClickCheckboxSelect} />;

    return (
        <>
            <Typography variant="h4">{__p('Variations', PLUGIN_NAME)} ({keyVariations.filter(key => !post.variations[key].delete).length})</Typography>
            <br />
            <Typography>{__p('Select', PLUGIN_NAME)}: <span onClick={handleClickSelectvariationsGroup('all')} className={classes.selectItem}>{__p('All', PLUGIN_NAME)}</span> <span onClick={handleClickSelectvariationsGroup('none')} className={classes.selectItem}>{__p('None', PLUGIN_NAME)}</span>
                {
                    Object.keys(attributes).map(keyAttr => (
                        valuesAttributes['attributes_' + attributes[keyAttr].id] ?
                            valuesAttributes['attributes_' + attributes[keyAttr].id].map(value => (
                                <span onClick={handleClickSelectvariationsGroup(keyAttr, value)} key={value.id} className={classes.selectItem}>{attributes[keyAttr].title}: {value.title}</span>
                            ))
                            : <></>
                    ))
                }
            </Typography>
            <br />
            <Table size="small" >
                <TableHead>
                    <TableRow>
                        {
                            keysVariationsSelected.length > 0 ?
                                <TableCell padding="none" style={{ height: 55 }} colSpan={100}>
                                    <div style={{ height: 36 }}>
                                        <ButtonGroup size="small">
                                            <Button onClick={handleClickCheckboxSelect} style={{ paddingLeft: 1, height: 36 }} size="small" startIcon={checkboxSelect}>
                                                {keysVariationsSelected.length} {__p('selected', PLUGIN_NAME)}
                                            </Button>
                                            <Button size="small" onClick={() => openBulkEditor[1](true)}>{__p('Open bulk editor', PLUGIN_NAME)}</Button>
                                        </ButtonGroup>
                                    </div>
                                </TableCell>
                                :
                                <>
                                    <TableCell padding="none" style={{ width: 42, height: 55 }}>
                                        {checkboxSelect}
                                    </TableCell>
                                    <TableCell>Variant <Typography variant="body2" style={{ whiteSpace: 'nowrap' }}>{
                                        Boolean(attributes) &&
                                        (() => {
                                            let keyMap = Object.keys(attributes);
                                            let result = '';

                                            keyMap.map((key, index) => {

                                                result += attributes[key].title;

                                                if (index < keyMap.length - 1) {
                                                    result += ' / ';
                                                }

                                            });
                                            return result;
                                        })()
                                    }</Typography></TableCell>
                                    <TableCell style={{ width: 40 }} padding='none'></TableCell>
                                    <TableCell>Name</TableCell>
                                    <TableCell>SKU</TableCell>
                                    <TableCell style={{ width: 40 }} >Price</TableCell>
                                    <TableCell>Quantity</TableCell>
                                    <TableCell style={{ width: 48 }}></TableCell>
                                </>
                        }
                    </TableRow>
                </TableHead>
                <TableBody>
                    {keyVariations.map((key, index) => (<TableRow className={classes.variationItem} onClick={handleEditVariation(key)} key={key}>
                        <TableCell padding="none" style={{ width: 40 }}>
                            <Checkbox
                                color='primary'
                                checked={variationsSelected[key] ? true : false}
                                onClick={(e) => {
                                    e.stopPropagation();
                                    setVariationsSelected(prev => {
                                        if (Boolean(prev[key])) {
                                            delete prev[key];
                                        } else {
                                            prev[key] = post.variations[key];
                                        }
                                        return { ...prev };
                                    });
                                }} />
                        </TableCell>
                        <TableCell component="th" scope="row" style={{ width: 250, whiteSpace: 'nowrap', cursor: 'pointer' }}>
                            {post.variations[key].label}
                        </TableCell>

                        {
                            !post.variations[key].delete ?
                                <>
                                    <TableCell padding='none' style={{ width: 40 }}>
                                        <div className={classes.variableImage}>
                                            <AvatarCustom image={post.variations[key].images} variant="square" name={post.variations[key].title} />
                                        </div>
                                    </TableCell>
                                    <TableCell style={{ whiteSpace: 'nowrap' }}>
                                        <Typography noWrap style={{ maxWidth: 200 }}>
                                            {post.variations[key].title}
                                        </Typography>
                                    </TableCell>
                                    <TableCell style={{ width: 80, whiteSpace: 'nowrap' }}>
                                        {post.variations[key].sku}
                                    </TableCell>
                                    <TableCell style={{ width: 80, whiteSpace: 'nowrap' }}>
                                        {moneyFormat(post.variations[key].price)}
                                    </TableCell>
                                    <TableCell style={{ width: 95, whiteSpace: 'nowrap' }}>
                                        {
                                            Boolean(post.variations[key].warehouse_manage_stock) &&
                                            post.variations[key].warehouse_quantity
                                        }
                                    </TableCell>
                                    <TableCell style={{ width: 48, whiteSpace: 'nowrap' }}>
                                        <Box display="flex" alignItems="center">
                                            <IconButton onClick={handleEditVariation(key)} color="default" aria-label="edit" component="span">
                                                <CreateOutlinedIcon />
                                            </IconButton>
                                            <IconButton style={{ color: theme.palette.secondary.main }} onClick={handleDeleteVariation(key)} color="default" aria-label="delete" component="span">
                                                <DeleteOutlineRoundedIcon />
                                            </IconButton>
                                        </Box>
                                    </TableCell>
                                </>
                                :
                                <>
                                    <TableCell colSpan={10} align="right">
                                        {/* <Typography variant="body1">{__p('This variant has been removed and will not appear on the storefront', PLUGIN_NAME)}</Typography> */}
                                    {/* </TableCell>
                                    <TableCell colSpan={6} align="right"> */}
                                        <IconButton style={{ color: theme.palette.success.main }} onClick={handleDeleteVariation(key)} color="default" aria-label="restore" component="span">
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
                onClose={() => { setEditVariationCurrent({ open: false }) }}
                title={__p('Edit Variation', PLUGIN_NAME)}
                width={1540}
                restDialogContent={{
                    className: 'custom_scroll ' + classes.drawerContent
                }}
            >
                <VariationsForm
                    PLUGIN_NAME={PLUGIN_NAME}
                    variations={post.variations}
                    postDetail={postDetail}
                    variationIndex={editVariationCurrent.key}
                    handleChangeVariations={handleChangeVariations}
                    attributes={attributes}
                    listValuesAttributes={listValuesAttributes}
                />
            </DrawerCustom>
            <BulkEditor
                open={openBulkEditor}
                variations={variationsSelected}
                attributes={attributes}
                onSave={(variationsChange) => {
                    console.log(variationsChange);
                    onReview({ ...post.variations, ...variationsChange });
                    openBulkEditor[1](false);
                }}
            />
        </>
    )
}

export default Variations
