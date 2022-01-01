import {
    Box,
    Button,
    Drawer
} from '@material-ui/core'
import CloseIcon from '@material-ui/icons/Close'
import DeleteIcon from '@material-ui/icons/DeleteOutlined'
import { makeStyles } from '@material-ui/styles'
import clsx from 'clsx'
import FieldForm from 'components/FieldForm'
import React, { useState } from 'react'

const useStyles = makeStyles((theme) => ({
    root: {
        height: '100%',
        display: 'flex',
        flexDirection: 'column',
    },
    drawer: {
        width: 620,
        maxWidth: '100%',
    },
    header: {
        padding: theme.spacing(2, 1),
        display: 'flex',
        justifyContent: 'flex-end',
    },
    buttonIcon: {
        marginRight: theme.spacing(1),
    },
    content: {
        padding: theme.spacing(0, 3),
        flexGrow: 1,
    },
    actions: {
        padding: theme.spacing(3),
        '& > *': {
            marginTop: theme.spacing(2),
        },
        '&>*:first-child': {
            marginRight: theme.spacing(2),
        },
    },
}))

export default function FilterSetting(props) {
    const { open, onClose, data, acctionPost, onFilter, className, ...rest } = props
    const classes = useStyles();

    const [flexible, setFlexible] = React.useState(false);
    let [post, setPost] = useState({ });

    React.useEffect(() => {

        const initialValues = [];

        if (data.config?.filters) {
            Object.keys(data.config.filters).forEach(key => {
                if (data.config.filters[key].default) {
                    initialValues.push({ ...data.config.filters[key], key: key, open: false, noDelete: true, noTrash: true, notFields: ['content', 'conditions'] });
                } else {
                    initialValues.push({ ...data.config.filters[key], key: key, open: false });
                }
            });

        }
        setPost({ filters: initialValues });
    }, [data]);

    React.useEffect(() => {

        if (data.config) {

            let templates = { };
            let argViewNotSearch = { relationship_onetoone_show: 1, relationship_onetomany_show: 1, relationship_manytomany_show: 1 };

            Object.keys(data.config.fields).forEach(key => {

                if (!data.config.fields[key].view) data.config.fields[key].view = 'inpnut';

                if (!argViewNotSearch[data.config.fields[key].view]) {

                    switch (data.config.fields[key].view) {
                        case 'number':
                            templates[key] = {
                                title: data.config.fields[key].title,
                                items: {
                                    from: { title: 'From', view: 'number' },
                                    to: { title: 'To', view: 'number' },
                                }
                            };
                            break;
                        case 'date_picker':
                            templates[key] = {
                                title: data.config.fields[key].title,
                                items: {
                                    from: { title: 'From', view: 'date_picker' },
                                    to: { title: 'To', view: 'date_picker' },
                                }
                            };
                            break;
                        case 'relationship_onetomany':
                            templates[key] = {
                                title: data.config.fields[key].title,
                                items: {
                                    [key]: {
                                        ...data.config.fields[key],
                                        view: 'relationship_manytomany',
                                    }
                                }
                            };
                            break;
                        case 'select':
                            templates[key] = {
                                title: data.config.fields[key].title,
                                items: {
                                    [key]: {
                                        ...data.config.fields[key],
                                        multiple: true,
                                    }
                                }
                            };
                            break;
                        default:
                            templates[key] = {
                                title: data.config.fields[key].title,
                                items: {
                                    [key]: data.config.fields[key]
                                }
                            };
                            break;
                    }

                }
            });

            let field = {
                key: 'filters_added',
                value: { },
                button_label: 'Add Filter',
                class: 'p-repeater',
                layout: 'block',
                titleHTML: true,
                sub_fields: {
                    title: { title: 'Title' },
                    icon: { title: 'Icon' },
                    color: { title: 'Color', view: 'color' },
                    conditions: {
                        title: 'Conditions',
                        view: 'PostTypeConditions',
                        type: data.type
                    },
                    // content: {
                    //     title: 'Condition',
                    //     view: 'flexible',
                    //     layout: 'block',
                    //     templates: templates,
                    // }
                }
            };
            setFlexible(field);
        }

    }, [data]);

    const onReview = (value, key) => {
        if (typeof key === 'object' && key !== null) {

            post = {
                ...post,
                ...key
            };
            // data.post[key] = value;
        } else {
            post[key] = value;
        }
    };

    const handleSubmit = (event) => {
        event.preventDefault();

        acctionPost({
            settingFilter: post.filters
        },
            () => {
                onClose();
            }
        );
    }

    const clearFilter = () => {
        const initialValues = [];

        if (data.config?.filters) {
            Object.keys(data.config.filters).forEach(key => {
                if (data.config.filters[key].default) {
                    initialValues.push({ ...data.config.filters[key], open: false, noDelete: true, noTrash: true, notFields: ['content'] });
                }
            });

        }
        setPost({ filters: initialValues });
    }


    return (
        <Drawer
            anchor="left"
            classes={{ paper: classes.drawer }}
            onClose={onClose}
            open={open}
            variant="temporary">
            <div
                {...rest}
                className={clsx(classes.root, className)}
            >
                <div className={classes.header}>
                    <Button onClick={onClose} size="small">
                        <CloseIcon className={classes.buttonIcon} />
                        Close
                    </Button>
                </div>
                <div className={classes.content}>

                    <FieldForm
                        compoment={'repeater'}
                        config={flexible}
                        post={post}
                        name={'filters'}
                        onReview={(value, key2 = 'filters') => onReview(value, key2)}
                    />
                </div>
                <Box display="flex" justifyContent="flex-end" className={classes.actions}>
                    <Button onClick={clearFilter} variant="contained">
                        <DeleteIcon className={classes.buttonIcon} />
                        Clear
                    </Button>
                    <Button
                        onClick={handleSubmit}
                        color="primary"
                        type="submit"
                        variant="contained">
                        Save filters
                    </Button>
                </Box>
            </div>
        </Drawer>
    )
}
