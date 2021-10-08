import {
  Tooltip
} from "@material-ui/core";
import AppBar from "@material-ui/core/AppBar";
import IconButton from "@material-ui/core/IconButton";
import { makeStyles } from "@material-ui/core/styles";
import Toolbar from "@material-ui/core/Toolbar";
import Typography from "@material-ui/core/Typography";
import AppsIcon from '@material-ui/icons/Apps';
import RefreshRoundedIcon from '@material-ui/icons/RefreshRounded';
import { login } from "actions/user";
import React from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link, useHistory } from "react-router-dom";
import { useAjax } from "utils/useAjax";
import Account from "./Header/Account";
import Notification from "./Header/Notification";
import Search from "./Header/Search";
import Tools from "./Header/Tools";
import { __ } from "utils/i18n";

const useStyles = makeStyles((theme) => ({
  root: {
    boxShadow: "none",
    zIndex: 99,
  },
  grow: {
    flexGrow: 1,
  },
  title: {
    display: "block",
    [theme.breakpoints.down("xs")]: {
      display: "none",
    },
    color: theme.palette.white,
  },
  sectionDesktop: {
    display: "flex",
  },
  header: {
    background: theme.palette.header.background,
    zIndex: 1350,
  },
}));

export default function Header() {

  let user = useSelector((state) => state.user);

  const history = useHistory();

  const classes = useStyles();

  const dispatch = useDispatch();

  const useAjax1 = useAjax({ loadingType: 'custom' });

  const handleRefreshWebsite = () => {

    useAjax1.ajax({
      url: "global/refresh",
      method: "POST",
      success: (result) => {

        if (result.sidebar) {
          dispatch(
            {
              type: 'SIDEBAR_UPDATE',
              payload: result.sidebar
            }
          );
        }

        dispatch(login({ ...user }))
      }
    });

  }

  return (
    <div className={classes.root}>
      <AppBar className={classes.header} position="static">
        <Toolbar>
          <Link to="/">
            <Typography className={classes.title} variant="h2" noWrap>
              Biong
            </Typography>
          </Link>

          <Search />

          <div className={classes.grow} />
          <div className={classes.sectionDesktop}>

            <Tooltip title={__("Refesh")}>
              <IconButton
                edge="start"
                color="inherit"
                onClick={handleRefreshWebsite}
              >
                <RefreshRoundedIcon />
              </IconButton>
            </Tooltip>

            <Tools />

            <Notification />

            <Tooltip title={__("Apps")}>
              <IconButton
                color="inherit"
                onClick={() => history.push('/coming-soon')}
              >
                <AppsIcon />
              </IconButton>
            </Tooltip>

            <Account handleRefreshWebsite={handleRefreshWebsite} />
          </div>
        </Toolbar>
      </AppBar>
    </div>
  );
}
