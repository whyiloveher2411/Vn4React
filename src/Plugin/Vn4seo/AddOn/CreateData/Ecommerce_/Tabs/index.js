import { Tooltip } from "@material-ui/core";
import FilterListOutlinedIcon from '@material-ui/icons/FilterListOutlined';

const tabs = (props) => {

    return {
        seoPer: {
            title: <Tooltip title="JSON-LD"><FilterListOutlinedIcon /></Tooltip>,
            content: () => { console.log(props); return <>Demo</> },
            hidden: props.postDetail.product_type !== 'variable',
            priority: 2,
        }
    }
}

export default tabs;