<?php

/**
 * BaseLimelight
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $score
 * @property string $profile_image
 * @property integer $total_views
 * @property integer $favorite_badge_flag
 * @property integer $reviewable
 * @property integer $wiki_lock
 * @property integer $spec_lock
 * @property integer $procon_lock
 * @property bool $module_specifications
 * @property bool $module_features
 * @property bool $module_procon
 * @property bool $module_products
 * @property enum $limelight_type
 * @property string $company_name
 * @property integer $company_id
 * @property integer $is_stub
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Categories
 * @property Doctrine_Collection $Newss
 * @property Doctrine_Collection $Wikis
 * @property Limelight $Company
 * @property Doctrine_Collection $Followers
 * @property Doctrine_Collection $CategoryLimelight
 * @property Doctrine_Collection $Products
 * @property Doctrine_Collection $Slices
 * @property Doctrine_Collection $Summaries
 * @property Doctrine_Collection $LimelightWikis
 * @property Doctrine_Collection $Specifications
 * @property Doctrine_Collection $LimelightNews
 * @property Doctrine_Collection $NewsLinks
 * @property Doctrine_Collection $UserAction
 * @property Doctrine_Collection $Owned
 * @property Doctrine_Collection $LimelightProCons
 * @property Doctrine_Collection $ProReviews
 * @property Doctrine_Collection $UserReviews
 * @property Doctrine_Collection $Favorited
 * @property Doctrine_Collection $Views
 * @property Doctrine_Collection $Scores
 * 
 * @method string              getName()                  Returns the current record's "name" value
 * @method integer             getScore()                 Returns the current record's "score" value
 * @method string              getProfileImage()          Returns the current record's "profile_image" value
 * @method integer             getTotalViews()            Returns the current record's "total_views" value
 * @method integer             getFavoriteBadgeFlag()     Returns the current record's "favorite_badge_flag" value
 * @method integer             getReviewable()            Returns the current record's "reviewable" value
 * @method integer             getWikiLock()              Returns the current record's "wiki_lock" value
 * @method integer             getSpecLock()              Returns the current record's "spec_lock" value
 * @method integer             getProconLock()            Returns the current record's "procon_lock" value
 * @method bool                getModuleSpecifications()  Returns the current record's "module_specifications" value
 * @method bool                getModuleFeatures()        Returns the current record's "module_features" value
 * @method bool                getModuleProcon()          Returns the current record's "module_procon" value
 * @method bool                getModuleProducts()        Returns the current record's "module_products" value
 * @method enum                getLimelightType()         Returns the current record's "limelight_type" value
 * @method string              getCompanyName()           Returns the current record's "company_name" value
 * @method integer             getCompanyId()             Returns the current record's "company_id" value
 * @method integer             getIsStub()                Returns the current record's "is_stub" value
 * @method sfGuardUser         getUser()                  Returns the current record's "User" value
 * @method Doctrine_Collection getCategories()            Returns the current record's "Categories" collection
 * @method Doctrine_Collection getNewss()                 Returns the current record's "Newss" collection
 * @method Doctrine_Collection getWikis()                 Returns the current record's "Wikis" collection
 * @method Limelight           getCompany()               Returns the current record's "Company" value
 * @method Doctrine_Collection getFollowers()             Returns the current record's "Followers" collection
 * @method Doctrine_Collection getCategoryLimelight()     Returns the current record's "CategoryLimelight" collection
 * @method Doctrine_Collection getProducts()              Returns the current record's "Products" collection
 * @method Doctrine_Collection getSlices()                Returns the current record's "Slices" collection
 * @method Doctrine_Collection getSummaries()             Returns the current record's "Summaries" collection
 * @method Doctrine_Collection getLimelightWikis()        Returns the current record's "LimelightWikis" collection
 * @method Doctrine_Collection getSpecifications()        Returns the current record's "Specifications" collection
 * @method Doctrine_Collection getLimelightNews()         Returns the current record's "LimelightNews" collection
 * @method Doctrine_Collection getNewsLinks()             Returns the current record's "NewsLinks" collection
 * @method Doctrine_Collection getUserAction()            Returns the current record's "UserAction" collection
 * @method Doctrine_Collection getOwned()                 Returns the current record's "Owned" collection
 * @method Doctrine_Collection getLimelightProCons()      Returns the current record's "LimelightProCons" collection
 * @method Doctrine_Collection getProReviews()            Returns the current record's "ProReviews" collection
 * @method Doctrine_Collection getUserReviews()           Returns the current record's "UserReviews" collection
 * @method Doctrine_Collection getFavorited()             Returns the current record's "Favorited" collection
 * @method Doctrine_Collection getViews()                 Returns the current record's "Views" collection
 * @method Doctrine_Collection getScores()                Returns the current record's "Scores" collection
 * @method Limelight           setName()                  Sets the current record's "name" value
 * @method Limelight           setScore()                 Sets the current record's "score" value
 * @method Limelight           setProfileImage()          Sets the current record's "profile_image" value
 * @method Limelight           setTotalViews()            Sets the current record's "total_views" value
 * @method Limelight           setFavoriteBadgeFlag()     Sets the current record's "favorite_badge_flag" value
 * @method Limelight           setReviewable()            Sets the current record's "reviewable" value
 * @method Limelight           setWikiLock()              Sets the current record's "wiki_lock" value
 * @method Limelight           setSpecLock()              Sets the current record's "spec_lock" value
 * @method Limelight           setProconLock()            Sets the current record's "procon_lock" value
 * @method Limelight           setModuleSpecifications()  Sets the current record's "module_specifications" value
 * @method Limelight           setModuleFeatures()        Sets the current record's "module_features" value
 * @method Limelight           setModuleProcon()          Sets the current record's "module_procon" value
 * @method Limelight           setModuleProducts()        Sets the current record's "module_products" value
 * @method Limelight           setLimelightType()         Sets the current record's "limelight_type" value
 * @method Limelight           setCompanyName()           Sets the current record's "company_name" value
 * @method Limelight           setCompanyId()             Sets the current record's "company_id" value
 * @method Limelight           setIsStub()                Sets the current record's "is_stub" value
 * @method Limelight           setUser()                  Sets the current record's "User" value
 * @method Limelight           setCategories()            Sets the current record's "Categories" collection
 * @method Limelight           setNewss()                 Sets the current record's "Newss" collection
 * @method Limelight           setWikis()                 Sets the current record's "Wikis" collection
 * @method Limelight           setCompany()               Sets the current record's "Company" value
 * @method Limelight           setFollowers()             Sets the current record's "Followers" collection
 * @method Limelight           setCategoryLimelight()     Sets the current record's "CategoryLimelight" collection
 * @method Limelight           setProducts()              Sets the current record's "Products" collection
 * @method Limelight           setSlices()                Sets the current record's "Slices" collection
 * @method Limelight           setSummaries()             Sets the current record's "Summaries" collection
 * @method Limelight           setLimelightWikis()        Sets the current record's "LimelightWikis" collection
 * @method Limelight           setSpecifications()        Sets the current record's "Specifications" collection
 * @method Limelight           setLimelightNews()         Sets the current record's "LimelightNews" collection
 * @method Limelight           setNewsLinks()             Sets the current record's "NewsLinks" collection
 * @method Limelight           setUserAction()            Sets the current record's "UserAction" collection
 * @method Limelight           setOwned()                 Sets the current record's "Owned" collection
 * @method Limelight           setLimelightProCons()      Sets the current record's "LimelightProCons" collection
 * @method Limelight           setProReviews()            Sets the current record's "ProReviews" collection
 * @method Limelight           setUserReviews()           Sets the current record's "UserReviews" collection
 * @method Limelight           setFavorited()             Sets the current record's "Favorited" collection
 * @method Limelight           setViews()                 Sets the current record's "Views" collection
 * @method Limelight           setScores()                Sets the current record's "Scores" collection
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLimelight extends Item
{
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('limelight');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('score', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('profile_image', 'string', 255, array(
             'type' => 'string',
             'default' => 'limelight_profile_default.gif',
             'length' => 255,
             ));
        $this->hasColumn('total_views', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('favorite_badge_flag', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 1,
             ));
        $this->hasColumn('reviewable', 'integer', 1, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 1,
             ));
        $this->hasColumn('wiki_lock', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 1,
             ));
        $this->hasColumn('spec_lock', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 1,
             ));
        $this->hasColumn('procon_lock', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 1,
             ));
        $this->hasColumn('module_specifications', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('module_features', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('module_procon', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('module_products', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('limelight_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'product',
              1 => 'technology',
              2 => 'company',
              3 => 'source',
             ),
             'default' => 'product',
             ));
        $this->hasColumn('company_name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('company_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('is_stub', 'integer', 1, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 1,
             ));


        $this->index('manufacturerIndex', array(
             'fields' => 
             array(
              0 => 'manufacturer',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Category as Categories', array(
             'refClass' => 'CategoryLimelight',
             'local' => 'limelight_id',
             'foreign' => 'category_id'));

        $this->hasMany('News as Newss', array(
             'refClass' => 'LimelightNews',
             'local' => 'limelight_id',
             'foreign' => 'news_id'));

        $this->hasMany('Wiki as Wikis', array(
             'refClass' => 'LimelightWiki',
             'local' => 'limelight_id',
             'foreign' => 'wiki_group_id'));

        $this->hasOne('Limelight as Company', array(
             'local' => 'company_id',
             'foreign' => 'id'));

        $this->hasMany('sfGuardUser as Followers', array(
             'refClass' => 'FollowLimelightReference',
             'local' => 'limelight_id',
             'foreign' => 'user_id'));

        $this->hasMany('CategoryLimelight', array(
             'local' => 'id',
             'foreign' => 'limelight_id'));

        $this->hasMany('Limelight as Products', array(
             'local' => 'id',
             'foreign' => 'company_id'));

        $this->hasMany('LimelightSlice as Slices', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightSummary as Summaries', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightWiki as LimelightWikis', array(
             'local' => 'id',
             'foreign' => 'limelight_id'));

        $this->hasMany('LimelightSpecification as Specifications', array(
             'local' => 'id',
             'foreign' => 'source_id'));

        $this->hasMany('LimelightNews', array(
             'local' => 'id',
             'foreign' => 'limelight_id'));

        $this->hasMany('NewsLink as NewsLinks', array(
             'local' => 'id',
             'foreign' => 'source_id'));

        $this->hasMany('UserAction', array(
             'local' => 'id',
             'foreign' => 'Limelight_id'));

        $this->hasMany('LimelightOwn as Owned', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightProCon as LimelightProCons', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightReviewPro as ProReviews', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightReviewUser as UserReviews', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightFavorite as Favorited', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightView as Views', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $this->hasMany('LimelightScore as Scores', array(
             'local' => 'id',
             'foreign' => 'item_id'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             'name' => 'name_slug',
             ));
        $this->actAs($sluggable0);
    }
}