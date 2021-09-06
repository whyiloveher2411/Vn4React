import { Checkbox, List, ListItem, ListItemSecondaryAction, ListItemText } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import React from 'react'

function SystemCheckList({ checkList }) {
    if (!checkList) {
        return <List dense>
            {[...Array(5)].map((key, index) => (
                <ListItem key={index} button>
                    <Skeleton animation="wave" height={30} style={{ marginBottom: 8, width: '100%', transform: 'scale(1, 1)' }} />
                </ListItem>
            ))}
        </List>
    }

    return <List dense>
        {Object.keys(checkList).map((key) => {
            const labelId = `checkbox-list-secondary-label-${checkList[key].title}`;
            return (
                <ListItem key={key} button>
                    <ListItemText id={labelId} primary={checkList[key].title} />
                    <ListItemSecondaryAction>
                        <Checkbox
                            edge="end"
                            onChange={() => { }}
                            checked={checkList[key].result}
                            inputProps={{ 'aria-labelledby': labelId }}
                        />
                    </ListItemSecondaryAction>
                </ListItem>
            );
        })}
    </List>
}

export default SystemCheckList
