import java.sql.*;

public class DBAccess {
    private static Statement statement = null;
    private static ResultSet resultSet = null;

    public static void main(String [] args )
    {
        String encoding = "&useUnicode=yes&characterEncoding=UTF-8";
        encoding = "";
        String localhost = "jdbc:mysql://localhost/project"
                + "?user=root" + encoding;
        try
        {
            Connection connection = DriverManager.getConnection(
                    localhost
            );
            System.out.println("Connected Succesfully");
            statement = connection.createStatement();

            initializeTables();
        }
        catch (SQLException e)
        {
            // do sth maybe
            System.out.println("Cannot connect");
            e.printStackTrace();
        }
    }
    private static void initializeTables()
    {
        createTables();
    }
    private static void createTables()
    {
        try {
            // Order of Drops is IMPORTANT
            statement.executeUpdate("drop table if exists has_taken;");
            statement.executeUpdate("drop table if exists collaborators;");
            statement.executeUpdate("drop table if exists service_ratings_evaluations;");
            statement.executeUpdate("drop table if exists provided;");
            statement.executeUpdate("drop table if exists past_services;");
            statement.executeUpdate("drop table if exists has;");
            statement.executeUpdate("drop table if exists matches;");
            statement.executeUpdate("drop table if exists service_orders;");
            statement.executeUpdate("drop table if exists provides;");
            statement.executeUpdate("drop table if exists provided_services;");
            statement.executeUpdate("drop table if exists proposed_collaborative_services;");
            statement.executeUpdate("drop table if exists proposals;");
            statement.executeUpdate("drop table if exists proposed_services;");
            statement.executeUpdate("drop table if exists services;");
            statement.executeUpdate("drop table if exists professional_users;");
            statement.executeUpdate("drop table if exists regular_users;");
            statement.executeUpdate("drop table if exists users;");

            statement.executeUpdate("CREATE TABLE users"+
                    "(user_ID INT PRIMARY KEY AUTO_INCREMENT,"+
                    "password VARCHAR(32) NOT NULL,"+
                    "email VARCHAR(32) NOT NULL UNIQUE,"+
                    "username VARCHAR(32) NOT NULL UNIQUE,"+
                    "city_name VARCHAR(32) DEFAULT NULL,"+
                    "street_number VARCHAR(32) DEFAULT NULL,"+
                    "apt_name VARCHAR(32) DEFAULT NULL,"+
                    "zip_code INT DEFAULT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE regular_users" +
                    "(user_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (user_ID) REFERENCES users( user_ID)" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE," +
                    "name VARCHAR (32) DEFAULT NULL," +
                    "surname VARCHAR (32) DEFAULT NULL," +
                    "date_of_birth DATE DEFAULT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE professional_users" +
                    "(user_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (user_ID) REFERENCES users( user_ID)\n" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE," +
                    "experience INT DEFAULT NULL," +
                    "expertise_field VARCHAR(32) DEFAULT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE services" +
                    "(service_type_ID INT PRIMARY KEY," +
                    "service_type_name VARCHAR(32) NOT NULL" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE past_services\n" +
                    "(service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)\n" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "PRIMARY KEY (service_type_ID, order_date, provider_ID)," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" + // DO NOT DELETE '\n' else it fails
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE service_orders" +
                    "(order_ID INT PRIMARY KEY," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_details VARCHAR(128)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE proposed_services" +
                    "(proposal_ID INT PRIMARY KEY," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "start_date DATE," +
                    "end_date DATE," +
                    "proposed_price INT" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE proposed_collaborative_services" +
                    "(proposal_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposed_services( proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "services VARCHAR(128)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE provided_services" +
                    "(service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES proposed_services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "custom_service_name VARCHAR(32)," +
                    "PRIMARY KEY (service_type_ID, custom_service_name)," +
                    "service_rating INT," +
                    "service_starting_date DATE," +
                    "service_ending_date DATE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE service_ratings_evaluations" +
                    "(PRIMARY KEY (user_ID, service_type_ID, order_date, provider_ID)," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES regular_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "rating INT," +
                    "evaluation VARCHAR(128)" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE has_taken" +
                    "(PRIMARY KEY (user_ID, service_type_ID, order_date, provider_ID)," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES regular_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE collaborators" +
                    "(proposal_ID INT PRIMARY KEY," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposed_services( proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES professional_users( user_ID)\n" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE proposals" +
                    "(PRIMARY KEY (professional_ID, proposal_ID)," +
                    "professional_ID INT," +
                    "FOREIGN KEY (professional_ID ) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "proposal_ID INT," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposed_services( proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE has" +
                    "(PRIMARY KEY (order_ID, user_ID)," +
                    "order_ID INT," +
                    "FOREIGN KEY (order_ID) REFERENCES service_orders (order_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES regular_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            statement.executeUpdate("CREATE TABLE provides" +
                    "(PRIMARY KEY (user_ID, service_type_ID)," +
                    "user_ID INT," +
                    "FOREIGN KEY (user_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "service_type_ID INT," +
                    "custom_service_name VARCHAR (32)," +
                    "FOREIGN KEY (service_type_ID,custom_service_name)  REFERENCES provided_services (service_type_ID,custom_service_name)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            // TODO: Related services is not working
            statement.executeUpdate("CREATE TABLE matches" +
                    "(PRIMARY KEY (order_ID, proposal_ID)," +
                    "order_ID INT," +
                    "FOREIGN KEY (order_ID) REFERENCES service_orders (order_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "proposal_ID INT," +
                    "FOREIGN KEY (proposal_ID) REFERENCES proposals (proposal_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
            // TODO: Sub Services (Things at the bottom right) not implemented
            statement.executeUpdate("CREATE TABLE provided" +
                    "(PRIMARY KEY (service_type_ID, order_date, provider_ID)," +
                    "service_type_ID INT," +
                    "FOREIGN KEY (service_type_ID) REFERENCES past_services( service_type_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE," +
                    "order_date DATE," +
                    "provider_ID INT," +
                    "FOREIGN KEY (provider_ID) REFERENCES professional_users( user_ID)" +
                    "ON DELETE CASCADE\n" +
                    "ON UPDATE CASCADE" +
                    ")engine=InnoDB;"
            );
        }catch (SQLException e)
        {
            e.printStackTrace();
        }
    }
}
