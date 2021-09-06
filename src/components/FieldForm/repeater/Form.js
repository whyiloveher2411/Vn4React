import { Accordion, AccordionDetails, AccordionSummary, Button, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, FormHelperText, Grid, IconButton, InputLabel, ListItemIcon, ListItemText, Menu, MenuItem, Table, TableBody, TableCell, TableContainer, TableRow, Typography } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import AddIcon from '@material-ui/icons/Add';
import AddToPhotosRoundedIcon from '@material-ui/icons/AddToPhotosRounded';
import ClearIcon from '@material-ui/icons/Clear';
import DeleteIcon from '@material-ui/icons/Delete';
import FileCopyIcon from '@material-ui/icons/FileCopy';
import MemoryIcon from '@material-ui/icons/Memory';
import MoreVertIcon from '@material-ui/icons/MoreVert';
import RestoreRoundedIcon from '@material-ui/icons/RestoreRounded';
import StarRoundedIcon from '@material-ui/icons/StarRounded';
import FieldForm from 'components/FieldForm';
import React, { useCallback } from 'react';
import { DragDropContext, Draggable, Droppable } from 'react-beautiful-dnd';
import { copyArray } from 'utils/helper';
import { useAjax } from 'utils/useAjax';

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
    },
    heading: {
        fontSize: theme.typography.pxToRem(15),
        display: 'flex',
        alignItems: 'center',
    },
    secondaryHeading: {
        fontSize: theme.typography.pxToRem(15),
        color: theme.palette.text.secondary,
    },
    icon: {
        verticalAlign: 'bottom',
        height: 20,
        width: 20,
    },
    dragcontext: {
        marginTop: 8
    },
    details: {
        alignItems: 'center',
        border: '1px solid #d5dadf',
        borderTop: 'none',
    },
    column: {
        flexBasis: '33.33%',
    },
    helper: {
        borderLeft: `2px solid ${theme.palette.divider}`,
        padding: theme.spacing(1, 2),
    },
    link: {
        color: theme.palette.primary.main,
        textDecoration: 'none',
        '&:hover': {
            textDecoration: 'underline',
        },
    },
    padding0: {
        padding: '8px 0 0 0'
    },
    cell: {
        verticalAlign: 'top',
        border: 'none',
    },
    stt: {
        fontWeight: 500
    },
    accordion: {
        boxShadow: 'none',
        padding: '5px 0 ',
        background: 'transparent',
        '&:before': {
            content: 'none'
        },
        '&.Mui-expanded': {
            margin: 0,
        },
        '& $stt': {
            color: '#a3a3a3'
        },
        '&.Mui-disabled $stt': {
            color: '#939393'
        },
        '&>.MuiAccordionSummary-root': {
            border: '1px solid #d5dadf',
            background: 'white',
            paddingRight: 0,
        },
        '&>.MuiAccordionSummary-root>.MuiAccordionSummary-content': {
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center',
            margin: 0
        }
    },
    accorDelete: {
        '&>.MuiAccordionSummary-root': {
            background: '#e6e6e6',
        },
    },
    emptyValue: {
        marginTop: 8,
        padding: 16,
        border: '1px dashed #b4b9be',
        cursor: 'pointer',
        borderRadius: 4,
        color: '#555d66'
    }
}));

export default React.memo(function RepeaterForm(props) {

    const classes = useStyles();

    let { config, post, name, onReview } = props;

    const [render, setRender] = React.useState(0);

    const [expandedAccordionData, setExpandedAccordionData] = React.useState([]);

    let { showNotification } = useAjax();

    let valueInital = [];

    try {
        if (typeof post[name] === 'object') {
            valueInital = post[name];
        } else {
            if (post[name]) {
                valueInital = JSON.parse(post[name]);
            } else {
                valueInital = [];
            }
        }

    } catch (error) {
        valueInital = [];
    }

    post[name] = valueInital;

    const expandedAccordion = (i, changeOpen) => {
        expandedAccordionData[i] = changeOpen;
        setExpandedAccordionData([...expandedAccordionData]);
        window.document.activeElement.blur();

        if (changeOpen) {
            post[name][i].open = changeOpen;
            onReview(post[name]);
        } else {
            setTimeout(() => {
                post[name][i].open = changeOpen;
                onReview(post[name]);
            }, 200);
        }
        setRender(prev => prev + 1);
    };

    let configKey = Object.keys(config.sub_fields);

    const keyTitle = configKey[0];

    const onBeforeCapture = useCallback(() => {
        document.activeElement.blur();
    }, []);
    const onBeforeDragStart = useCallback(() => {
        /*...*/
    }, []);
    const onDragStart = useCallback(() => {
        /*...*/
    }, []);
    const onDragUpdate = useCallback((result) => {

    }, []);

    const onDragEnd = useCallback((result) => {

        if (result.destination) {
            let [reorderItem] = post[name].splice(result.source.index, 1);
            post[name].splice(result.destination.index, 0, reorderItem);
            onReview(post[name]);
            setRender(prev => prev + 1);
        }

    });

    const onChangeInputRepeater = (value, index, key) => {

        console.log('onChangeInputRepeater', post[name]);

        try {
            if (typeof post[name] !== 'object') {
                if (post && post[name]) {
                    post[name] = JSON.parse(post[name]);
                }
            }
        } catch (error) {
            post[name] = [];
        }

        if (typeof key === 'object' && key !== null) {

            post[name][index] = {
                ...post[name][index],
                ...key
            };

        } else {

            post[name][index] = {
                ...post[name][index],
                [key]: value
            };
        }
        onReview(post[name]);
        setRender(prev => prev + 1);
    };

    const deleteRepeater = index => {
        let items = copyArray(valueInital);
        if (index > -1) {
            items.splice(index, 1);
        }
        post[name] = items;
        setIndexOfAction(false);
        onReview(post[name]);
        setRender(prev => prev + 1);
    };

    const openDialogConfirmDelete = () => {
        let items = copyArray(valueInital);
        items[indexOfAction].confirmDelete = true;
        post[name] = items;
        onReview(post[name]);
        setRender(prev => prev + 1);
    };

    const closeDialogConfirmDelete = index => {
        let items = copyArray(valueInital);
        items[index].confirmDelete = false;
        post[name] = items;
        onReview(post[name]);
        setRender(prev => prev + 1);
    };

    const handleStar = () => {
        let items = copyArray(valueInital);
        if (items[indexOfAction]) {
            items[indexOfAction].star = items[indexOfAction].star * 1 ? 0 : 1;
            post[name] = items;
            setIndexOfAction(false);
            onReview(post[name]);
        }
    };

    const trashRepeater = () => {
        let items = copyArray(valueInital);

        if (items[indexOfAction]) {
            items[indexOfAction].delete = items[indexOfAction].delete * 1 ? 0 : 1;
            post[name] = items;
            setIndexOfAction(false);
            onReview(post[name]);
        }
    };

    const handleDuplicateItem = () => {
        let items = copyArray(valueInital);

        if (items[indexOfAction]) {
            let item = copyArray(items[indexOfAction]);
            items.splice(indexOfAction, 0, item);
            post[name] = items;
            setIndexOfAction(false);
            onReview(post[name]);
        }
    };

    const handleCopyToClipboard = () => {
        let item = { config: config, value: copyArray(valueInital[indexOfAction]) };
        navigator.clipboard.writeText(JSON.stringify(item));
        showNotification('Copied to clipboard.', 'info');
        setIndexOfAction(false);
    };

    const handlePasteFromClipboard = () => {
        let items = copyArray(valueInital);
        if (items[indexOfAction]) {
            navigator.clipboard.readText()
                .then(text => {
                    let itemFromclipboard = JSON.parse(text);

                    if (JSON.stringify(itemFromclipboard.config) === JSON.stringify(config)) {
                        if (itemFromclipboard.value) {
                            items[indexOfAction] = { ...itemFromclipboard.value, open: items[indexOfAction].open };
                            post[name] = items;
                            showNotification('Paste from clipboard success.', 'success');
                        } else {
                            showNotification('Paste from clipboard error.', 'warning');
                        }
                    } else {
                        showNotification("Can't synchronize two different groups of structures.", 'error');
                    }

                    setIndexOfAction(false);
                    onReview(post[name]);
                })
                .catch(() => {
                    showNotification('Paste from clipboard error.', 'warning');
                    setIndexOfAction(false);
                });
        }
    }

    const addElement = () => {

        let items = [];

        if (valueInital && typeof valueInital === 'object') {
            items = copyArray(valueInital);
        }
        items.push({
            open: true,
            confirmDelete: false,
            delete: 0,
        });
        post[name] = items;
        onReview(post[name]);
        setRender(prev => prev + 1);
    };

    // React.useEffect(() => {
    //     console.log('CHNAGE VALUE REPEATER: ', post[name]);
    //     onReview(post[name]);
    // }, [render]);

    console.log('render REPEATER')

    const [refMenuAction, setRefMenuAction] = React.useState(null);

    const [indexOfAction, setIndexOfAction] = React.useState(false);

    return (
        <div className={classes.root}>
            <InputLabel>{config.title}</InputLabel>
            {
                Boolean(config.note) &&
                <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
            }
            {
                valueInital && valueInital[0]
                    ?
                    <>
                        <DragDropContext
                            onBeforeCapture={onBeforeCapture}
                            onBeforeDragStart={onBeforeDragStart}
                            onDragStart={onDragStart}
                            onDragUpdate={onDragUpdate}
                            onDragEnd={onDragEnd}
                        >
                            <Droppable droppableId={name + '_droppable_id'}>
                                {
                                    (provided) => (
                                        <div className={classes.dragcontext} {...provided.droppableProps} ref={provided.innerRef}>
                                            {
                                                valueInital.map((item, index) => {
                                                    return (
                                                        <Draggable key={index} draggableId={'_id' + index} index={index}>
                                                            {
                                                                (provided) => (
                                                                    <Accordion
                                                                        className={classes.accordion + ' ' + (item.delete * 1 === 1 && classes.accorDelete)}
                                                                        defaultExpanded={true}
                                                                        expanded={
                                                                            typeof expandedAccordionData[index] === 'undefined' ?
                                                                                (item.open ? item.open : false)
                                                                                : expandedAccordionData[index]
                                                                        }
                                                                        onChange={(e, o) => expandedAccordion(index, o)}
                                                                        {...provided.draggableProps}
                                                                        ref={provided.innerRef}>
                                                                        <AccordionSummary
                                                                            {...provided.dragHandleProps}
                                                                        >
                                                                            {
                                                                                config.titleHTML ?
                                                                                    <Typography className={classes.heading}>
                                                                                        <span className={classes.stt}>{index + 1}.&nbsp;</span> <span dangerouslySetInnerHTML={{ __html: !item[keyTitle] ? 'Item' : (item[keyTitle] && typeof item[keyTitle] === 'object') ? item[keyTitle][0]?.title : item[keyTitle] }} />
                                                                                        {
                                                                                            item.star * 1 === 1 &&
                                                                                            <StarRoundedIcon style={{ marginBottom: '5px', color: 'rgb(244, 180, 0)' }} />
                                                                                        }
                                                                                    </Typography>
                                                                                    :
                                                                                    <Typography className={classes.heading}>
                                                                                        <span className={classes.stt}>{index + 1}.&nbsp;</span> {!item[keyTitle] ? 'Item' : (item[keyTitle] && typeof item[keyTitle] === 'object') ? item[keyTitle][0]?.title : item[keyTitle]}
                                                                                        {
                                                                                            item.star * 1 === 1 &&
                                                                                            <StarRoundedIcon style={{ marginBottom: '5px', color: 'rgb(244, 180, 0)' }} />
                                                                                        }
                                                                                    </Typography>
                                                                            }
                                                                            <span>

                                                                                <IconButton onClick={(e) => { e.stopPropagation(); setIndexOfAction(index); setRefMenuAction(e.currentTarget); }} ref={indexOfAction === index ? refMenuAction : null} aria-label="Delete" component="span">
                                                                                    <MoreVertIcon />
                                                                                </IconButton>

                                                                                <Dialog
                                                                                    open={item.confirmDelete ? true : false}
                                                                                    onClose={() => closeDialogConfirmDelete(index)}
                                                                                    onClick={e => e.stopPropagation()}
                                                                                    aria-labelledby="alert-dialog-title"
                                                                                    aria-describedby="alert-dialog-description">
                                                                                    <DialogTitle id="alert-dialog-title">{"Confirm Deletion"}</DialogTitle>
                                                                                    <DialogContent>
                                                                                        <DialogContentText id="alert-dialog-description">
                                                                                            Are you sure you want to permanently remove this item?  {index}
                                                                                        </DialogContentText>
                                                                                    </DialogContent>
                                                                                    <DialogActions>
                                                                                        <Button onClick={e => { e.stopPropagation(); closeDialogConfirmDelete(index); }} color="default" >
                                                                                            Cancel
                                                                                        </Button>
                                                                                        <Button onClick={e => { e.stopPropagation(); deleteRepeater(index); }} color="primary" autoFocus>
                                                                                            OK
                                                                                        </Button>
                                                                                    </DialogActions>
                                                                                </Dialog>
                                                                            </span>
                                                                        </AccordionSummary>

                                                                        {
                                                                            item.open &&
                                                                            (
                                                                                !config.layout || config.layout === 'table' ?
                                                                                    <AccordionDetails className={classes.details + ' ' + classes.padding0} >
                                                                                        <TableContainer>
                                                                                            <Table {...config.layoutProps}>
                                                                                                <TableBody>
                                                                                                    <TableRow>
                                                                                                        {
                                                                                                            configKey &&
                                                                                                            configKey.map(key => {
                                                                                                                if (item.notFields && item.notFields.indexOf(key) !== - 1) {
                                                                                                                    return <React.Fragment key={key}></React.Fragment>;
                                                                                                                }
                                                                                                                return (
                                                                                                                    <TableCell key={key} className={classes.cell} >
                                                                                                                        <FieldForm
                                                                                                                            compoment={config.sub_fields[key].view ? config.sub_fields[key].view : 'text'}
                                                                                                                            config={config.sub_fields[key]}
                                                                                                                            post={item ?? {}}
                                                                                                                            name={key}
                                                                                                                            onReview={(value, key2 = key) => onChangeInputRepeater(value, index, key2)}
                                                                                                                        />
                                                                                                                    </TableCell>
                                                                                                                )
                                                                                                            })
                                                                                                        }
                                                                                                    </TableRow>
                                                                                                </TableBody>
                                                                                            </Table>
                                                                                        </TableContainer>
                                                                                    </AccordionDetails>
                                                                                    :
                                                                                    <AccordionDetails className={classes.details} >
                                                                                        <Grid
                                                                                            container
                                                                                            spacing={4}
                                                                                            style={{ marginTop: 0 }}
                                                                                            {...config.layoutProps}
                                                                                        >
                                                                                            {
                                                                                                configKey &&
                                                                                                configKey.map(key => {

                                                                                                    if (item.notFields && item.notFields.indexOf(key) !== - 1) {
                                                                                                        return <React.Fragment key={key}></React.Fragment>;
                                                                                                    }

                                                                                                    return (
                                                                                                        <Grid item md={12} xs={12} key={key} >
                                                                                                            <FieldForm
                                                                                                                compoment={config.sub_fields[key].view ? config.sub_fields[key].view : 'text'}
                                                                                                                config={config.sub_fields[key]}
                                                                                                                post={item ?? {}}
                                                                                                                name={key}
                                                                                                                onReview={(value, key2 = key) => onChangeInputRepeater(value, index, key2)}
                                                                                                            />
                                                                                                        </Grid>
                                                                                                    )
                                                                                                })
                                                                                            }
                                                                                        </Grid>
                                                                                    </AccordionDetails>
                                                                            )
                                                                        }
                                                                    </Accordion>
                                                                )
                                                            }
                                                        </Draggable>
                                                    )
                                                })
                                            }
                                            {provided.placeholder}
                                        </div>
                                    )
                                }
                            </Droppable>
                        </DragDropContext>
                        <div style={{ display: 'flex', justifyContent: 'flex-end', marginTop: 8 }}>
                            <Button style={{ width: '100%' }} startIcon={<AddIcon />}
                                variant="contained" onClick={addElement} color="primary" aria-label="add" className={classes.fabButton}>
                                Add {config.singular_name ?? 'Item'}
                            </Button>
                        </div>
                    </>
                    :
                    <Grid
                        container
                        direction="row"
                        justify="center"
                        alignItems="center"
                        onClick={addElement}
                        className={classes.emptyValue}
                    >Add {config.singular_name ?? 'Item'}</Grid>
            }
            {
                Boolean(!config.actions || config.actions !== 'none') &&
                <Menu
                    anchorEl={refMenuAction}
                    onClose={() => { setIndexOfAction(false); }}
                    open={Boolean(refMenuAction && indexOfAction !== false)}
                    getContentAnchorEl={null}
                    PaperProps={{
                        style: {
                            minWidth: '20ch',
                        },
                    }}
                    anchorOrigin={{
                        vertical: 'bottom',
                        horizontal: 'center',
                    }}
                    transformOrigin={{
                        vertical: 'top',
                        horizontal: 'center',
                    }}>

                    {
                        Boolean(!config.actions || config.actions.star) &&
                        <MenuItem onClick={handleStar}>
                            <ListItemIcon>
                                <StarRoundedIcon />
                            </ListItemIcon>
                            <ListItemText disableTypography primary="Star" />
                        </MenuItem>
                    }

                    {
                        Boolean(!config.actions || config.actions.duplicate) &&
                        <MenuItem onClick={handleDuplicateItem}>
                            <ListItemIcon>
                                <AddToPhotosRoundedIcon />
                            </ListItemIcon>
                            <ListItemText disableTypography primary="Duplicate" />
                        </MenuItem>
                    }

                    {
                        Boolean(!config.actions || config.actions.copy) &&
                        <MenuItem onClick={handleCopyToClipboard}>
                            <ListItemIcon>
                                <MemoryIcon />
                            </ListItemIcon>
                            <ListItemText disableTypography primary="Copy to clipboard" />
                        </MenuItem>
                    }

                    {
                        Boolean(!config.actions || config.actions.paste) &&
                        <MenuItem onClick={handlePasteFromClipboard}>
                            <ListItemIcon>
                                <FileCopyIcon />
                            </ListItemIcon>
                            <ListItemText disableTypography primary="Paste from clipboard" />
                        </MenuItem>
                    }

                    {
                        Boolean(!config.actions || config.actions.trash) &&
                        (
                            indexOfAction !== false && (!valueInital[indexOfAction].noTrash) &&
                            (
                                post[name][indexOfAction] && post[name][indexOfAction].delete ?
                                    <MenuItem onClick={trashRepeater}>
                                        <ListItemIcon>
                                            <RestoreRoundedIcon />
                                        </ListItemIcon>
                                        <ListItemText disableTypography primary="Restore" />
                                    </MenuItem>
                                    :
                                    <MenuItem onClick={trashRepeater}>
                                        <ListItemIcon>
                                            <DeleteIcon />
                                        </ListItemIcon>
                                        <ListItemText disableTypography primary="Trash" />
                                    </MenuItem>
                            )
                        )
                    }
                    {
                        Boolean(!config.actions || config.actions.delete) &&
                        (
                            indexOfAction !== false && (!valueInital[indexOfAction].noDelete) &&
                            <MenuItem onClick={openDialogConfirmDelete}>
                                <ListItemIcon>
                                    <ClearIcon />
                                </ListItemIcon>
                                <ListItemText disableTypography primary="Delete" />
                            </MenuItem>
                        )
                    }
                </Menu>
            }
        </div>
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
