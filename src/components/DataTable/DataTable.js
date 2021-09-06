import { Card, CardContent, CardHeader, Checkbox, Divider, IconButton, makeStyles, Table, TableBody, TableCell, TableHead, TableRow, Tooltip } from '@material-ui/core'
import React from 'react'
import StarOutlinedIcon from '@material-ui/icons/StarOutlined';
import StarBorderOutlinedIcon from '@material-ui/icons/StarBorderOutlined';

const data = {
    config: {
        title: 'Notifications',
        fields: {
            severity: { title: 'Severity', view: 'text' },
            created_at: { title: 'Date Added', view: 'text' },
            message: { title: 'Message', view: 'text' },
            action: { title: 'Action', view: 'text' },
        }
    }
}


const useStyles = makeStyles((theme) => ({
    root: {
        paddingBottom: 56,
    },
    results: {
        marginTop: theme.spacing(3),
    },
    cardWarper: {
        position: 'relative',
        '&>.MuiCardHeader-root>.MuiCardHeader-action': {
            margin: 0
        }
    },
    cardHeader: {
        padding: 0,
        '& .MuiCardHeader-action': {
            alignSelf: 'center'
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
    iconStar: {
        width: 40,
        height: 40,
        opacity: 0.5,
        color: '#202124',
        '&:hover': {
            opacity: 1
        }
    },
    trRowAction: {
        position: 'relative',
    },
    pad8: {
        paddingLeft: 8,
        paddingRight: 8,
    },
    rowRecord: {
        cursor: 'pointer',
        '&:hover': {
            '& .actionPost': {
                opacity: 1
            }
        },
        '&>td': {
            padding: 8
        },
        '&>.MuiTableCell-paddingCheckbox': {
            padding: '0 0 0 4px'
        }
    },
}))

function DataTable() {

    const classes = useStyles();

    return (
        <Card className={classes.cardWarper}>
            {/* <CardHeader
                className={classes.cardHeader}
                title={'Hello'}
            />
            <Divider /> */}
            <CardContent className={classes.content}>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell padding="checkbox">
                                <Checkbox
                                    checked={false}
                                    color="primary"
                                    indeterminate={false}
                                    onClick={() => { }}
                                />
                            </TableCell>
                            <TableCell padding="checkbox">

                            </TableCell>
                            <TableCell className={classes.pad8}>Severity</TableCell>
                            <TableCell className={classes.pad8}>Date Added</TableCell>
                            <TableCell className={classes.pad8}>Message</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {
                            [... (new Array(5))].map(index => (
                                <TableRow>
                                    <TableCell padding="checkbox">
                                        <Tooltip title="Select" aria-label="select">
                                            <Checkbox
                                                checked={false}
                                                color="primary"
                                                onChange={(event) => { }}
                                                onClick={() => { }}
                                                value={1}
                                            />
                                        </Tooltip>
                                    </TableCell>
                                    <TableCell padding="checkbox">
                                        <Tooltip title={'Starred'} aria-label="Star">
                                            <IconButton
                                                onClick={(e) => { }}
                                                color="default"
                                                className={classes.iconStar}
                                                aria-label="Back"
                                                component="span">
                                                <StarBorderOutlinedIcon />
                                            </IconButton>
                                        </Tooltip>
                                    </TableCell>

                                    <TableCell >
                                        notice
                                    </TableCell>
                                    <TableCell >
                                        May 11, 2021, 3:44:41 PM
                                    </TableCell>
                                    <TableCell >
                                        Magento Open Source 2.4.2-p1 & 2.3.7 deliver important security updates
                                        The latest releases of Magento Open Source – 2.3.7 and 2.4.2-p1 – are now generally available. The latest release of Magento Open Source includes important security updates. With these important updates we strongly recommend that you upgrade to ensure your sites maintain the highest level of security. You can review the release notes for more information about all of the updates. Learn how this release can help you save time and maximize resources at Magento.com/blog.
                                    </TableCell>
                                </TableRow>
                            ))
                        }
                    </TableBody>
                </Table>
            </CardContent>

        </Card>
    )
}

export default DataTable
