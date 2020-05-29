const Sequelize = require('sequelize');
const db = require('../config/database');

const Notif = db.define('v_notif', {
    user_ext: {
        type: Sequelize.STRING,
        allowNull: false,
    },
    title: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    url: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    time: {
        type: Sequelize.DATE,
        allowNull: false,
    },
    ticket_id: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    type: {
        type: Sequelize.STRING,
        allowNull: true,
    }
}, {
    timestamps: false
});


module.exports = Notif;
