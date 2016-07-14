<?php
/**
 * Created by PhpStorm.
 * User: liuyong
 * Date: 16/7/14
 * Time: 下午2:07
 */

namespace App\Library;
/**
 *
 *  $config['total_rows'] = 200;
 *  $config['per_page'] = 20;
 *  $pages = new Pagination($config);
 * Class Pagination
 * @package App\Library
 */

class Pagination
{
    /**
     * Base URL
     *
     * The page that we're linking to
     *
     * @var	string
     */
    protected $base_url		= '';

    /**
     * Prefix
     *
     * @var	string
     */
    protected $prefix = '';

    /**
     * Suffix
     *
     * @var	string
     */
    protected $suffix = '';

    /**
     * Total number of items
     *
     * @var	int
     */
    protected $total_rows = 0;

    /**
     * Number of links to show
     *
     * Relates to "digit" type links shown before/after
     * the currently viewed page.
     *
     * @var	int
     */
    protected $num_links = 2;

    /**
     * Items per page
     *
     * @var	int
     */
    public $per_page = 10;

    /**
     * Current page
     *
     * @var	int
     */
    public $cur_page = 0;

    /**
     * Use page numbers flag
     *
     * Whether to use actual page numbers instead of an offset
     *
     * @var	bool
     */
    protected $use_page_numbers = TRUE;

    /**
     * First link
     *
     * @var	string
     */
    protected $first_link = '首页';

    /**
     * Next link
     *
     * @var	string
     */
    protected $next_link = '&gt;';

    /**
     * Previous link
     *
     * @var	string
     */
    protected $prev_link = '&lt;';

    /**
     * Last link
     *
     * @var	string
     */
    protected $last_link = '尾页';

    /**
     * URI Segment
     *
     * @var	int
     */
    protected $uri_segment = 0;

    /**
     * Full tag open
     *
     * @var	string
     */
    protected $full_tag_open = '';

    /**
     * Full tag close
     *
     * @var	string
     */
    protected $full_tag_close = '';

    /**
     * First tag open
     *
     * @var	string
     */
    protected $first_tag_open = '';

    /**
     * First tag close
     *
     * @var	string
     */
    protected $first_tag_close = '';

    /**
     * Last tag open
     *
     * @var	string
     */
    protected $last_tag_open = '';

    /**
     * Last tag close
     *
     * @var	string
     */
    protected $last_tag_close = '';

    /**
     * First URL
     *
     * An alternative URL for the first page
     *
     * @var	string
     */
    protected $first_url = '';

    /**
     * Current tag open
     *
     * @var	string
     */
    protected $cur_tag_open = '<strong>';

    /**
     * Current tag close
     *
     * @var	string
     */
    protected $cur_tag_close = '</strong>';

    /**
     * Next tag open
     *
     * @var	string
     */
    protected $next_tag_open = '';

    /**
     * Next tag close
     *
     * @var	string
     */
    protected $next_tag_close = '';

    /**
     * Previous tag open
     *
     * @var	string
     */
    protected $prev_tag_open = '';

    /**
     * Previous tag close
     *
     * @var	string
     */
    protected $prev_tag_close = '';

    /**
     * Number tag open
     *
     * @var	string
     */
    protected $num_tag_open = '';

    /**
     * Number tag close
     *
     * @var	string
     */
    protected $num_tag_close = '';

    /**
     * Page query string flag
     *
     * @var	bool
     */
    protected $page_query_string = FALSE;

    /**
     * Query string segment
     *
     * @var	string
     */
    protected $query_string_segment = 'page';

    /**
     * Display pages flag
     *
     * @var	bool
     */
    protected $display_pages = TRUE;

    /**
     * Link types
     *
     * "rel" attribute
     *
     * @see	CI_Pagination::_attr_rel()
     * @var	array
     */
    protected $_link_types = array();

    /**
     * Reuse query string flag
     *
     * @var	bool
     */
    protected $reuse_query_string = TRUE;

    /**
     * Use global URL suffix flag
     *
     * @var	bool
     */
    protected $use_global_url_suffix = FALSE;

    /**
     *
     * @var	object
     */
    protected $pageParam;

    // --------------------------------------------------------------------

    /**
     * Constructor
     *
     * @param	array	$params	Initialization parameters
     *
     */
    public function __construct($params = array())
    {
        $this->pageParam = loadConfig('page');
        $this->initialize($params);
    }

    // --------------------------------------------------------------------

    /**
     * Initialize Preferences
     *
     * @param	array	$params	Initialization parameters
     * @return Pagination
     */
    public function initialize(array $params = array())
    {

        foreach ($params as $key => $val)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $val;
            }
        }

        if ($this->use_global_url_suffix === TRUE)
        {
            $this->suffix = $this->pageParam['url_suffix'];;
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Generate the pagination links
     *
     * @return	string
     */
    public function create_links()
    {
        // If our item count or per-page total is zero there is no need to continue.
        // Note: DO NOT change the operator to === here!
        if ($this->total_rows == 0 OR $this->per_page == 0)
        {
            return '';
        }

        // Calculate the total number of pages
        $num_pages = (int) ceil($this->total_rows / $this->per_page);

        // Is there only one page? Hm... nothing more to do here then.
        if ($num_pages === 1)
        {
            return '';
        }

        // Check the user defined number of links.
        $this->num_links = (int) $this->num_links;

        if ($this->num_links < 0)
        {
            show_error('页数必须大于0');
        }

        // Keep any existing query string items.
        // Note: Has nothing to do with any other query string option.
        if ($this->reuse_query_string === TRUE)
        {
            $get = $_GET;
            unset($get['page']);
        }
        else
        {
            $get = array();
        }

        // Put together our base and first URLs.
        // Note: DO NOT append to the properties as that would break successive calls
        $base_url = trim($this->base_url);
        $first_url = $this->first_url;

        $query_string_sep = (strpos($base_url, '?') === FALSE) ? '?' : '&amp;';

        // Are we using query strings?

            // If a custom first_url hasn't been specified, we'll create one from
            // the base_url, but without the page item.
        if ($first_url === '')
        {
            $first_url = $base_url;

            // If we saved any GET items earlier, make sure they're appended.
            if ( ! empty($get))
            {
                $first_url .= $query_string_sep.http_build_query($get);
            }
        }

        // Add the page segment to the end of the query string, where the
        // page number will be appended.
        $base_url .= $query_string_sep.http_build_query(array_merge($get, array($this->query_string_segment => '')));

        // Determine the current page number.
        $base_page = ($this->use_page_numbers) ? 1 : 0;
        $this->cur_page = (isset($_GET[$this->query_string_segment]) && intval($_GET[$this->query_string_segment])) ? intval($_GET[$this->query_string_segment]) : 1;

        // Is the page number beyond the result range?
        // If so, we show the last page.
        if ($this->use_page_numbers)
        {
            if ($this->cur_page > $num_pages)
            {
                $this->cur_page = $num_pages;
            }
        }
        elseif ($this->cur_page > $this->total_rows)
        {
            $this->cur_page = ($num_pages - 1) * $this->per_page;
        }

        $uri_page_number = $this->cur_page;

        // If we're using offset instead of page numbers, convert it
        // to a page number, so we can generate the surrounding number links.
        if ( ! $this->use_page_numbers)
        {
            $this->cur_page = (int) floor(($this->cur_page/$this->per_page) + 1);
        }

        // Calculate the start and end numbers. These determine
        // which number to start and end the digit links with.
        $start	= (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
        $end	= (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

        // And here we go...
        $output = '';
        // Render the "First" link.
        if ($this->first_link !== FALSE && $this->cur_page > ($this->num_links + 1 + ! $this->num_links))
        {
            $output .= $this->first_tag_open.'<a href="'.$first_url.'">'
                .$this->first_link.'</a>'.$this->first_tag_close;
        }

        // Render the "Previous" link.
        if ($this->prev_link !== FALSE && $this->cur_page !== 1)
        {
            $i = ($this->use_page_numbers) ? $uri_page_number - 1 : $uri_page_number - $this->per_page;

            if ($i === $base_page)
            {
                // First page
                $output .= $this->prev_tag_open.'<a href="'.$first_url.'">'
                    .$this->prev_link.'</a>'.$this->prev_tag_close;
            }
            else
            {
                $append = $this->prefix.$i.$this->suffix;
                $output .= $this->prev_tag_open.'<a href="'.$base_url.$append.'">'
                    .$this->prev_link.'</a>'.$this->prev_tag_close;
            }

        }
        // Render the pages
        if ($this->display_pages !== FALSE)
        {
            // Write the digit links
            for ($loop = $start - 1; $loop <= $end; $loop++)
            {
                $i = ($this->use_page_numbers) ? $loop : ($loop * $this->per_page) - $this->per_page;

                if ($i >= $base_page)
                {
                    if ($this->cur_page === $loop)
                    {
                        // Current page
                        $output .= $this->cur_tag_open.$loop.$this->cur_tag_close;
                    }
                    elseif ($i === $base_page)
                    {
                        // First page
                        $output .= $this->num_tag_open.'<a href="'.$first_url.'">'
                            .$loop.'</a>'.$this->num_tag_close;
                    }
                    else
                    {
                        $append = $this->prefix.$i.$this->suffix;
                        $output .= $this->num_tag_open.'<a href="'.$base_url.$append.'"'.'>'
                            .$loop.'</a>'.$this->num_tag_close;
                    }
                }
            }
        }

        // Render the "next" link
        if ($this->next_link !== FALSE && $this->cur_page < $num_pages)
        {
            $i = ($this->use_page_numbers) ? $this->cur_page + 1 : $this->cur_page * $this->per_page;

            $output .= $this->next_tag_open.'<a href="'.$base_url.$this->prefix.$i.$this->suffix.'">'.$this->next_link.'</a>'.$this->next_tag_close;
        }

        // Render the "Last" link
        if ($this->last_link !== FALSE && ($this->cur_page + $this->num_links + ! $this->num_links) < $num_pages)
        {
            $i = ($this->use_page_numbers) ? $num_pages : ($num_pages * $this->per_page) - $this->per_page;

            $output .= $this->last_tag_open.'<a href="'.$base_url.$this->prefix.$i.$this->suffix.'"'.'>'
                .$this->last_link.'</a>'.$this->last_tag_close;
        }

        // Kill double slashes. Note: Sometimes we can end up with a double slash
        // in the penultimate link so we'll kill all double slashes.
        $output = preg_replace('#([^:"])//+#', '\\1/', $output);
        // Add the wrapper HTML if exists
        return $this->full_tag_open.$output.$this->full_tag_close;
    }
}