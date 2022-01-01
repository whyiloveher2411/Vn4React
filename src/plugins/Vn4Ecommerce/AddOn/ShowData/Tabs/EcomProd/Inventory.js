import { Box, Button, ButtonGroup, Card, CardActions, CardContent, CircularProgress, makeStyles, TableBody, TablePagination, Typography } from '@material-ui/core';
import Table from '@material-ui/core/Table';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import { Skeleton } from '@material-ui/lab';
import { AvatarCustom, FieldForm, MaterialIcon } from 'components';
import { PLUGIN_NAME } from 'plugins/Vn4Ecommerce/helpers/plugin';
import React from 'react';
import { __, __p } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';

const stock_status = {
    instock: { title: __p('In stock', PLUGIN_NAME), color: '#7ad03a' },
    outofstock: { title: __p('Out of stock', PLUGIN_NAME), color: '#a44' },
    onbackorder: { title: __p('On backorder', PLUGIN_NAME), color: '#eaa600' },
};


const useStyles = makeStyles((theme) => ({
    container: {
        maxHeight: 550,
    },
    content: {
        padding: 0,
    },
    actions: {
        padding: theme.spacing(1),
        justifyContent: 'flex-end',
    },
    iconLoading: {
        position: 'absolute',
        zIndex: 2,
        top: 'calc(50% - 20px)',
        left: 'calc(50% - 20px)',
    },
    cardWarper: {
        position: 'relative',
        '&>.MuiCardHeader-root>.MuiCardHeader-action': {
            margin: 0
        }
    },
    showLoading: {
        '&::before': {
            display: 'inline-block',
            content: '""',
            position: 'absolute',
            left: 0,
            right: 0,
            bottom: 0,
            top: 0,
            background: 'rgba(0, 0, 0, 0.1)',
            zIndex: 1,
        }
    },
}))

const ProductVariable = ({ product, index, handleChangeSetType, onReview, handleClickSave }) => {
    return (
        <TableRow key={product.key}>
            <TableCell padding='none'></TableCell>
            <TableCell padding='none'>
                <AvatarCustom variant="square" style={{ width: 56, height: 56 }} image={product.thumbnail} name={product.title} />
            </TableCell>
            <TableCell>
                <Typography variant="body2">#{product.identifier.id}</Typography>
                <Typography variant='h6'>{product.title}</Typography>
                {
                    product.variationLabel !== false &&
                    <Typography>{product.variationLabel}</Typography>
                }
            </TableCell>
            <TableCell>
                {product.sku}
            </TableCell>
            <TableCell>
                {
                    Boolean(product.warehouse_manage_stock) &&
                    <>
                        {
                            product.when_sold_out === 'no' ?
                                __p('Stop selling', PLUGIN_NAME) :
                                __p('Continue selling', PLUGIN_NAME)
                        }
                    </>
                }
            </TableCell>
            <TableCell>
                <Box display="flex" alignItems="center" gridGap={4}>

                    {
                        Boolean(product.warehouse_manage_stock) ?
                            <>
                                {product.warehouse_quantity}
                                {
                                    Boolean(product.warehouse_quantity_after_set !== false && !isNaN(product.warehouse_quantity_after_set) && parseInt(product.warehouse_quantity_after_set) !== parseInt(product.warehouse_quantity)) &&
                                    <>
                                        <MaterialIcon icon={{ custom: '<path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16z"></path>' }} />
                                        <Typography style={{ borderRadius: 4, backgroundColor: '#ffea8a', color: 'rgb(32, 34, 35)', padding: '0 4px', display: 'inline-block' }}>
                                            {product.warehouse_quantity_after_set}
                                        </Typography>
                                    </>
                                }
                            </>
                            :
                            <>
                                {stock_status[product.stock_status]?.title}
                            </>
                    }
                </Box>
            </TableCell>
            <TableCell>
                {
                    Boolean(product.warehouse_manage_stock) &&
                    <Box display="flex" gridGap={4}>
                        <ButtonGroup size="small" aria-label="small outlined button group">
                            <Button
                                style={(!product.setType || product.setType === 'add') ? { width: 60, backgroundColor: '#e0e0e0', color: 'black' } : { width: 60 }}
                                key="one"
                                onClick={() => {
                                    handleChangeSetType('add', index);
                                }}
                            >
                                {__p('Add', PLUGIN_NAME)}
                            </Button>
                            <Button
                                style={product.setType === 'set' ? { width: 60, backgroundColor: '#e0e0e0', color: 'black' } : { width: 60 }}
                                key="two"
                                onClick={() => {
                                    handleChangeSetType('set', index);
                                }}
                            >
                                {__p('Set', PLUGIN_NAME)}
                            </Button>
                        </ButtonGroup>
                        <div style={{ width: 75 }}>
                            <FieldForm
                                compoment="number"
                                config={{
                                    title: false,
                                    size: 'small',
                                    forceRender: true,
                                }}
                                post={{ count: product.count ? product.count : 0 }}
                                name="count"
                                onReview={onReview}
                            />
                        </div>
                        <Button
                            size="small"
                            disabled={!Boolean(product.warehouse_quantity_after_set !== false && !isNaN(product.warehouse_quantity_after_set) && parseInt(product.warehouse_quantity_after_set) !== parseInt(product.warehouse_quantity))}
                            variant="contained"
                            color="primary"
                            onClick={() => handleClickSave(product, index)}
                        >
                            {__p('Save', PLUGIN_NAME)}
                        </Button>
                    </Box>
                }
            </TableCell>
        </TableRow>
    )
}

const ProductItem = ({ product, index, handleChangeSetType, setProducts, handleClickSave }) => {
    return (
        <TableRow key={product.key}>
            <TableCell>
                <AvatarCustom variant="square" style={{ width: 56, height: 56 }} image={product.thumbnail} name={product.title} />
            </TableCell>
            <TableCell padding='none'></TableCell>
            <TableCell>
                <Typography variant="body2">#{product.identifier.id}</Typography>
                <Typography variant='h6'>{product.title}</Typography>
                {
                    product.variationLabel !== false &&
                    <Typography>{product.variationLabel}</Typography>
                }
            </TableCell>
            <TableCell>
                {product.sku}
            </TableCell>
            <TableCell>
                {
                    Boolean(product.warehouse_manage_stock) &&
                    <>
                        {
                            product.when_sold_out === 'no' ?
                                __p('Stop selling', PLUGIN_NAME) :
                                __p('Continue selling', PLUGIN_NAME)
                        }
                    </>
                }
            </TableCell>
            <TableCell>
                <Box display="flex" alignItems="center" gridGap={4}>

                    {
                        Boolean(product.warehouse_manage_stock) ?
                            <>
                                {product.warehouse_quantity}
                                {
                                    Boolean(product.warehouse_quantity_after_set !== false && !isNaN(product.warehouse_quantity_after_set) && parseInt(product.warehouse_quantity_after_set) !== parseInt(product.warehouse_quantity)) &&
                                    <>
                                        <MaterialIcon icon={{ custom: '<path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16z"></path>' }} />
                                        <Typography style={{ borderRadius: 4, backgroundColor: '#ffea8a', color: 'rgb(32, 34, 35)', padding: '0 4px', display: 'inline-block' }}>
                                            {product.warehouse_quantity_after_set}
                                        </Typography>
                                    </>
                                }
                            </>
                            :
                            <>
                                {stock_status[product.stock_status]?.title}
                            </>
                    }
                </Box>
            </TableCell>
            <TableCell>
                {
                    Boolean(product.warehouse_manage_stock) &&
                    <Box display="flex" gridGap={4}>
                        <ButtonGroup size="small" aria-label="small outlined button group">
                            <Button
                                style={(!product.setType || product.setType === 'add') ? { width: 60, backgroundColor: '#e0e0e0', color: 'black' } : { width: 60 }}
                                key="one"
                                onClick={() => {
                                    handleChangeSetType('add', index);
                                }}
                            >
                                {__p('Add', PLUGIN_NAME)}
                            </Button>
                            <Button
                                style={product.setType === 'set' ? { width: 60, backgroundColor: '#e0e0e0', color: 'black' } : { width: 60 }}
                                key="two"
                                onClick={() => {
                                    handleChangeSetType('set', index);
                                }}
                            >
                                {__p('Set', PLUGIN_NAME)}
                            </Button>
                        </ButtonGroup>
                        <div style={{ width: 75 }}>
                            <FieldForm
                                compoment="number"
                                config={{
                                    title: false,
                                    size: 'small',
                                    forceRender: true,
                                }}
                                post={{ count: product.count ? product.count : 0 }}
                                name="count"
                                onReview={(value) => {
                                    setProducts(prev => {
                                        prev[index].count = value;

                                        if (!prev[index].setType || prev[index].setType === 'add') {
                                            prev[index].warehouse_quantity_after_set = parseInt(prev[index].warehouse_quantity) + parseInt(value);
                                        } else {
                                            prev[index].warehouse_quantity_after_set = value;
                                        }

                                        return [...prev];
                                    });
                                }}
                            />
                        </div>
                        <Button
                            size="small"
                            disabled={!Boolean(product.warehouse_quantity_after_set !== false && !isNaN(product.warehouse_quantity_after_set) && parseInt(product.warehouse_quantity_after_set) !== parseInt(product.warehouse_quantity))}
                            variant="contained"
                            color="primary"
                            onClick={() => handleClickSave(product, index)}
                        >
                            {__p('Save', PLUGIN_NAME)}
                        </Button>
                    </Box>
                }
            </TableCell>
        </TableRow>
    )
}

function Inventory() {

    const [products, setProducts] = React.useState(false);

    const classes = useStyles();

    const ajaxInventory = useAjax();

    const [paginate, setPaginate] = React.useState({
        total: 0,
        per_page: 0,
        current_page: 0,
    });

    const handleUpdateData = () => {

        setPaginate(paginate => {
            ajaxInventory.ajax({
                url: 'plugin/vn4-ecommerce/inventory/product-listing',
                data: {
                    page: paginate.page ? paginate.page : 0,
                    per_page: paginate.per_page ? paginate.per_page : 10,
                },
                success: (result) => {
                    if (result.products) {
                        setProducts(result.products);
                    }
                    if (result.paginate) {
                        setPaginate(result.paginate);
                    }
                },
            });

            return paginate;
        });

    }

    React.useEffect(() => {
        handleUpdateData();
    }, []);

    const handleClickSave = (product, index) => {
        ajaxInventory.ajax({
            url: 'plugin/vn4-ecommerce/inventory/product-listing',
            data: {
                setQuantity: true,
                identifier: product.identifier,
                count: product.count,
                setType: (!product.setType || product.setType === 'add') ? 'add' : 'set',
            },
            success: (result) => {
                if (result.warehouse_quantity) {

                    setProducts(prev => {
                        prev[index].count = '';
                        prev[index].warehouse_quantity = result.warehouse_quantity;
                        prev[index].warehouse_quantity_after_set = false;
                        prev[index].setType = 'add';
                        return [...prev];
                    });
                }
            },
        });
    }

    const handleClickSaveVariable = (product, index, indexVariable) => {
        ajaxInventory.ajax({
            url: 'plugin/vn4-ecommerce/inventory/product-listing',
            data: {
                setQuantity: true,
                identifier: product.identifier,
                count: product.count,
                setType: (!product.setType || product.setType === 'add') ? 'add' : 'set',
            },
            success: (result) => {
                if (result.warehouse_quantity) {

                    setProducts(prev => {
                        prev[index].variables[indexVariable].count = '';
                        prev[index].variables[indexVariable].warehouse_quantity = result.warehouse_quantity;
                        prev[index].variables[indexVariable].warehouse_quantity_after_set = false;
                        prev[index].variables[indexVariable].setType = 'add';
                        return [...prev];
                    });
                }
            },
        });
    }



    const handleChangeSetType = (type, index) => {
        setProducts(prev => {
            prev[index].setType = type;
            if (!prev[index].setType || prev[index].setType === 'add') {
                prev[index].warehouse_quantity_after_set = parseInt(prev[index].warehouse_quantity) + (parseInt(prev[index].count) > 0 ? parseInt(prev[index].count) : 0);
            } else {
                prev[index].warehouse_quantity_after_set = parseInt(prev[index].count) > 0 ? parseInt(prev[index].count) : 0;
            }

            return [...prev];
        })
    }

    if (products) {

        return (
            <Card className={classes.cardWarper + ' ' + (ajaxInventory.open ? classes.showLoading : '')}>
                <CardContent className={classes.content}>
                    <TableContainer className={classes.container + ' custom_scroll'}>
                        <Table stickyHeader >
                            <TableHead>
                                <TableRow>
                                    <TableCell style={{ width: 56 }}>
                                    </TableCell>
                                    <TableCell style={{ width: 56 }} padding='none'>
                                    </TableCell>
                                    <TableCell>
                                        {__p('Product', PLUGIN_NAME)}
                                    </TableCell>
                                    <TableCell>
                                        {__p('SKU', PLUGIN_NAME)}
                                    </TableCell>
                                    <TableCell>
                                        {__p('When sold out', PLUGIN_NAME)}
                                    </TableCell>
                                    <TableCell style={{ width: 200 }}>
                                        {__p('Available', PLUGIN_NAME)}
                                    </TableCell>
                                    <TableCell style={{ width: 300 }}>
                                        {__p('Edit quantity available', PLUGIN_NAME)}
                                    </TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {
                                    products.map((product, index) => (
                                        <React.Fragment key={product.key}>
                                            <ProductItem
                                                product={product}
                                                index={index}
                                                handleChangeSetType={handleChangeSetType}
                                                setProducts={setProducts}
                                                handleClickSave={handleClickSave}
                                            />
                                            {
                                                product.product_type === 'variable' && product.variables?.length &&
                                                product.variables.map((productVariable, index2) => (
                                                    <ProductVariable
                                                        key={index2}
                                                        product={productVariable}
                                                        index={index2}
                                                        handleChangeSetType={(type) => {
                                                            setProducts(prev => {
                                                                prev[index].variables[index2].setType = type;

                                                                if (!prev[index].variables[index2].setType || prev[index].variables[index2].setType === 'add') {
                                                                    prev[index].variables[index2].warehouse_quantity_after_set = parseInt(prev[index].variables[index2].warehouse_quantity) + (parseInt(prev[index].variables[index2].count) > 0 ? parseInt(prev[index].variables[index2].count) : 0);
                                                                } else {
                                                                    prev[index].variables[index2].warehouse_quantity_after_set = parseInt(prev[index].variables[index2].count) > 0 ? parseInt(prev[index].variables[index2].count) : 0;
                                                                }

                                                                return [...prev];
                                                            });

                                                        }}
                                                        onReview={(value) => {

                                                            setProducts(prev => {
                                                                prev[index].variables[index2].count = value;

                                                                if (!prev[index].variables[index2].setType || prev[index].variables[index2].setType === 'add') {
                                                                    prev[index].variables[index2].warehouse_quantity_after_set = parseInt(prev[index].variables[index2].warehouse_quantity) + parseInt(value);
                                                                } else {
                                                                    prev[index].variables[index2].warehouse_quantity_after_set = value;
                                                                }

                                                                return [...prev];
                                                            });
                                                        }}
                                                        handleClickSave={() => {
                                                            setProducts(prev => {
                                                                handleClickSaveVariable(prev[index].variables[index2], index, index2)
                                                                return prev;
                                                            })
                                                        }}
                                                    />
                                                ))

                                            }
                                        </React.Fragment>
                                    ))
                                }
                            </TableBody>
                        </Table>
                    </TableContainer>
                </CardContent>
                <CardActions className={classes.actions}>
                    <TablePagination
                        component="div"
                        count={paginate.total ? paginate.total * 1 : 0}
                        onChangePage={(event, v) => {
                            setPaginate(prev => {
                                prev.page = v + 1;
                                return { ...prev };
                            });
                            handleUpdateData();
                        }}
                        onChangeRowsPerPage={(event) => {
                            setPaginate(prev => ({ ...prev, per_page: event.target.value }));
                            handleUpdateData();
                        }}
                        page={paginate.current_page ? paginate.current_page - 1 : 0}
                        rowsPerPage={paginate.per_page ? paginate.per_page * 1 : 10}
                        rowsPerPageOptions={[10, 25, 50, 100]}
                        labelRowsPerPage={__p('Product per page:', PLUGIN_NAME)}
                        labelDisplayedRows={({ from, to, count }) => `${from} - ${to} ${__('of')} ${count !== -1 ? count : `${__('more than')} ${to}`}`}
                    />
                </CardActions>
                {ajaxInventory.open && <CircularProgress value={75} className={classes.iconLoading} />}
            </Card>
        )
    }

    return (
        <TableContainer>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableCell style={{ width: 56 }} padding='none'>
                            <Skeleton height={23} width={'100%'} />
                        </TableCell>
                        <TableCell>
                            <Skeleton height={23} width={'100%'} />
                        </TableCell>
                        <TableCell>
                            <Skeleton height={23} width={'100%'} />
                        </TableCell>
                        <TableCell>
                            <Skeleton height={23} width={'100%'} />
                        </TableCell>
                        <TableCell>
                            <Skeleton height={23} width={'100%'} />
                        </TableCell>
                        <TableCell style={{ width: 300 }}>
                            <Skeleton height={23} width={'100%'} />
                        </TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>

                    {
                        [...Array(10).keys()].map((key) => (
                            <TableRow key={key}>
                                <TableCell padding='none'>
                                    <Skeleton height={56} width={56} variant="rect" />
                                </TableCell>
                                <TableCell>
                                    <Skeleton height={20} width={'100%'} />
                                    <Skeleton height={20} width={'100%'} />
                                </TableCell>
                                <TableCell>
                                    <Skeleton height={36} width={'100%'} />
                                </TableCell>
                                <TableCell>
                                    <Skeleton height={36} width={'100%'} />
                                </TableCell>
                                <TableCell>
                                    <Skeleton height={36} width={'100%'} />
                                </TableCell>
                                <TableCell>
                                    <Box width={1} alignItems="center" display="flex" gridGap={4}>
                                        <Skeleton width={'100%'} height={36} />
                                        <Skeleton width={'100%'} height={36} />
                                        <Skeleton width={'100%'} height={36} />
                                    </Box>
                                </TableCell>
                            </TableRow>
                        ))
                    }
                </TableBody>
            </Table>
        </TableContainer>
    )

}

export default Inventory
