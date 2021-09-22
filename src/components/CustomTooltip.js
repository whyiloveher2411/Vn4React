import { Tooltip, withStyles } from '@material-ui/core';

const CustomTooltip = withStyles((theme) => ({
    tooltip: {
        color: theme.palette.text.primary,
        backgroundColor: theme.palette.background.paper,
        margin: 5,
        minWidth: 250,
        maxWidth: 450,
        fontSize: 13,
        boxShadow: '0 4px 5px 0 rgb(0 0 0 / 14%), 0 1px 10px 0 rgb(0 0 0 / 12%), 0 2px 4px -1px rgb(0 0 0 / 20%)',
        fontWeight: 400,
        lineHeight: '22px',
        padding: 16,
        '& a': {
            color: theme.palette.text.primary,
            display: 'block',
            font: '500 14px / 20px Roboto,RobotoDraft,Helvetica,Arial,sans-serif',
            letterSpacing: '.5px',
            lineHeight: '16px',
            paddingTop: '8px',
            textTransform: 'uppercase',
            opacity: .7,
            '&:hover': {
                opacity: 1,
            }
        }
    }
}))(Tooltip);


export default CustomTooltip;

