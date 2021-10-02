import React from 'react';
import Timeline from '@material-ui/lab/Timeline';
import TimelineItem from '@material-ui/lab/TimelineItem';
import TimelineSeparator from '@material-ui/lab/TimelineSeparator';
import TimelineConnector from '@material-ui/lab/TimelineConnector';
import TimelineContent from '@material-ui/lab/TimelineContent';
import TimelineDot from '@material-ui/lab/TimelineDot';
import TimelineOppositeContent from '@material-ui/lab/TimelineOppositeContent';
import Visibility from '@material-ui/icons/Visibility';
import VisibilityOff from '@material-ui/icons/VisibilityOff';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import InputAdornment from '@material-ui/core/InputAdornment';
import Tooltip from '@material-ui/core/Tooltip';
import { FieldForm, MaterialIcon } from 'components';
import { Box, makeStyles, Button } from '@material-ui/core';
import { useAjax } from 'utils/useAjax';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .MuiTimelineOppositeContent-root': {
            width: 210,
            flex: 'unset',
        }
    },
    iconRemove: {
        display: 'none',
    },
    iconType: {

    },
    timelineDot: {
        cursor: 'pointer',
        '&:hover $iconType': {
            display: 'none'
        },
        '&:hover $iconRemove': {
            display: 'block'
        },
    }
}));

function History(props) {

    const classes = useStyles();

    const [historys, setHistorys] = React.useState([]);

    const { ajax, Loading } = useAjax();

    const [dataNote, setDataNote] = React.useState({
        message: '',
        type: 'private'
    });

    React.useEffect(() => {

        let valueInital = [];

        try {
            if (props.post.history && typeof props.post.history === 'object') {
                valueInital = props.post.history;
            } else {
                if (props.post.history) {
                    valueInital = JSON.parse(props.post.history);
                }
            }
        } catch (error) {
            valueInital = [];
        }

        setHistorys(valueInital);

    }, [props.post.history]);

    const handleClick = () => {
        setDataNote(prev => ({ ...prev, type: prev.type === 'private' ? 'customer' : 'private' }))
    }

    const handleAddNote = () => {
        if (dataNote.message) {
            ajax({
                url: 'plugin/vn4-ecommerce/order/history',
                data: {
                    ...dataNote,
                },
                success: (result) => {
                    if (result.history) {
                        let historys2 = [...historys, result.history];

                        props.onReview(historys2, props.name);
                        setDataNote({
                            message: '',
                            type: 'private'
                        });
                    }
                }
            });
        }
    }

    const setMessage = (message, param) => {

        let find = Object.keys(param);
        let replace = Object.values(param);

        var replaceString = message;
        for (var i = 0; i < find.length; i++) {
            replaceString = replaceString.replace('{{' + find[i] + '}}', replace[i]);
        }

        return replaceString;
    }

    const handleRemove = (index) => (e) => {
        setHistorys(prev => {
            let items = [...prev];
            items.splice(index, 1);
            props.onReview(items, props.name);
            return items;
        });
    };

    return (
        <div className={classes.root}>
            <Timeline align="left">
                {
                    historys.map((item, index) => (
                        <TimelineItem key={index}>
                            <TimelineOppositeContent>
                                <Typography color="textSecondary">{item.created_at}</Typography>
                            </TimelineOppositeContent>
                            <TimelineSeparator>
                                <Tooltip title={item.type === 'primary' ? 'Primary' : 'Note to Customer'}>
                                    <TimelineDot onClick={handleRemove(index)} className={classes.timelineDot} style={{ backgroundColor: item.type === 'primary' ? '#7903da' : '#43a047' }} >

                                        <MaterialIcon className={classes.iconRemove} icon="ClearOutlined" />

                                        <MaterialIcon className={classes.iconType} icon={item.type === 'primary' ? 'PersonOutlined' : 'PeopleAltOutlined'} />

                                    </TimelineDot>
                                </Tooltip>
                                {
                                    index !== (historys.length - 1) ?
                                        <TimelineConnector />
                                        : <></>
                                }
                            </TimelineSeparator>
                            <TimelineContent>
                                <Typography>{setMessage(item.message, item.paramMessage)}</Typography>
                                <Typography variant="body2">By {item.by.name} ({item.by.email})</Typography>
                            </TimelineContent>
                        </TimelineItem>
                    ))
                }
            </Timeline>
            <Box display="flex" flexDirection="column" gridGap={16}>
                <FieldForm
                    compoment='textarea'
                    config={{
                        title: 'Add Note',
                    }}
                    post={dataNote}
                    name="message"
                    forceUpdate
                    onReview={(value) => { setDataNote(prev => ({ ...prev, message: value })) }}
                    endAdornment={
                        <InputAdornment position="end">
                            <Tooltip title="Note to Customer">
                                <IconButton
                                    aria-label="toggle password visibility"
                                    onClick={handleClick}
                                    edge="end"
                                >
                                    {dataNote.type === 'private' ? <VisibilityOff /> : <Visibility />}
                                </IconButton>
                            </Tooltip>
                        </InputAdornment>
                    }
                />
                <div style={{ textAlign: 'right ' }}>
                    <Button onClick={handleAddNote} variant="contained" color="primary">
                        Add
                    </Button>
                </div>
            </Box>
            {Loading}
        </div>
    )
}

export default History
